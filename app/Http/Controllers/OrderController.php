<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderImg;
use Illuminate\Http\Request;
use Storage;
use File;
use Image;
use Carbon\Carbon;
use Stripe\{Stripe, Charge, Customer};
use Illuminate\Support\Facades\DB;
use App\Mail\OrderNew;
use App\Mail\OrderCancelled;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('index', 'create', 'store', 'checkout');
        $this->middleware('notPayed')->only('edit', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = auth()->user()->orders;
        
        $pre = [];
        $current = [];
        $past = [];

        foreach ($orders as $order) {
            if ($order->trans == null && $order->end_date >= Carbon::yesterday() && $order->is_payed && !$order->is_cancelled) {
                $pre = array_prepend($pre, $order);
            }

            if ($order->trans && !$order->trans->is_received && $order->end_date >= Carbon::yesterday() && $order->is_payed && !$order->is_cancelled) {
                $current = array_prepend($current, $order);
            }

            if (($order->trans && $order->trans->is_received) || ($order->end_date < Carbon::yesterday() && $order->is_payed) || $order->is_cancelled) {
                $past = array_prepend($past, $order);
            }
        }

        $relatedOrders = Order::where('is_payed', true)->inRandomOrder()->limit(15)->get();
        
        return view('order.index', compact('pre', 'current', 'past', 'relatedOrders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $relatedOrders = Order::where('is_payed', true)->inRandomOrder()->limit(10)->get();
        return view('order.create', compact('relatedOrders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'name' => request('name'),
            'price' => request('price'),
            'category' => request('category'),
            'country' => request('country'),
            'description' => request('description'),
            'link' => request('link'),
            'end_date' => request('endDate'),
        ]);

        if (request('copyOrderId')) {
            $copyOrder = Order::find(request('copyOrderId'));
            foreach ($copyOrder->orderImgs as $image) {
                $original = Storage::get('orderImgs/originals/'.$copyOrder->id.'/'.$image->filename.'.jpg');
                $thumbnail = Storage::get('orderImgs/thumbnails/'.$copyOrder->id.'/'.$image->filename.'.jpg');

                Storage::disk('s3')->put('orderImgs/originals/'.$order->id.'/'.$image->filename.'.jpg', $original);
                Storage::disk('s3')->put('orderImgs/thumbnails/'.$order->id.'/'.$image->filename.'.jpg', $thumbnail);

                OrderImg::create([
                    'order_id' => $order->id,
                    'filename' => $image->filename,
                    'mime' => $image->mime,
                    'original_filename' => $image->original_filename,
                ]);
            }
        }

        if (request('orderImgs')) {
            foreach (request('orderImgs') as $image) {

                $image_thumb = Image::make($image);
                if ($image_thumb->height() <= $image_thumb->width()) {
                    $image_thumb = $image_thumb->crop($image_thumb->height(), $image_thumb->height())->resize(500, 500);
                } else {
                    $image_thumb = $image_thumb->crop($image_thumb->width(), $image_thumb->width())->resize(500, 500);
                }
                $image_thumb = $image_thumb->stream();

                Storage::disk('s3')->put('orderImgs/originals/'.$order->id.'/'.$image->getFilename().'.jpg', File::get($image));
                Storage::disk('s3')->put('orderImgs/thumbnails/'.$order->id.'/'.$image->getFilename().'.jpg', $image_thumb->__toString());

                OrderImg::create([
                    'order_id' => $order->id,
                    'filename' => $image->getFilename(),
                    'mime' => $image->getClientMimeType(),
                    'original_filename' => $image->getClientOriginalName(),
                ]);
            }
        }

        return view('order.store', compact('order'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $comments = $order->comments()->orderBy('created_at', 'desc')->get();
        $relatedOrders = Order::where('category', '=', $order->category)->orWhere('country', '=', $order->country)->inRandomOrder()->limit(20)->get();
        return view('order.show', compact('order', 'comments', 'relatedOrders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $Order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $relatedOrders = Order::where('is_payed', true)->inRandomOrder()->limit(15)->get();
        return view('order.edit', compact('order', 'relatedOrders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $Order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update([
            'name' => request('name'),
            'price' => request('price'),
            'category' => request('category'),
            'country' => request('country'),
            'description' => request('description'),
            'link' => request('link'),
            'end_date' => request('endDate'),
        ]);

        return view('order.store', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $Order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function checkout(Order $order)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $customer = Customer::create([
            'email' => request('stripeEmail'),
            'source'  => request('stripeToken')
        ]);

        $charge = Charge::create([
            'customer' => $customer->id,
            'amount'   => $order->price * 100,
            'currency' => 'hkd'
        ]);

        if ($charge) {
            $order->is_payed = true;
            $order->save();
        }

        \Mail::to($order->user)->send(new OrderNew($order->user, $order));

        return redirect()->action('OrderController@index');
    }

    public function search()
    {        
        $orders = Order::where('is_payed', true);

        if (request('name') != null) {
            $sName = strtolower(request('name'));
            $orders = $orders->where('name', 'ILIKE', '%'.$sName.'%');
        }

        if (request('category') != null) {
            $sCategory = request('category');
            $orders = $orders->where('category', $sCategory);
        }

        if (request('country') != null) {
            $sCountry = request('country');
            $orders = $orders->where('country', $sCountry);
        }

        if (request('price') != null) {
            $sPrice = request('price');
            $orders = $orders->where('price', '<=', $sPrice);
        }

        if (request('endDate') != null) {
            $sDate = request('endDate');
            $orders = $orders->where('end_date', '<=', $sDate);
        }

        $orders = $orders->inRandomOrder()->paginate(20);
        
        return view('order.search', compact('orders'));
    }

    public function cancel(Order $order, Request $request)
    {
        $order->is_cancelled = true;
        $order->save();

        \Mail::to($order->user)->send(new OrderCancelled($order->user, $order));

        return redirect()->action('OrderController@index');
    }
}
