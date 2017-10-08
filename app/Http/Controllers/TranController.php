<?php

namespace App\Http\Controllers;

use App\Tran;
use App\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\OrderAccepted;

class TranController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trans = auth()->user()->trans;
        
        $pre = [];
        foreach ($trans as $tran) {
            if (!$tran->is_received && $tran->order->end_date >= Carbon::yesterday() && $tran->order->is_payed) {
                $pre = array_prepend($pre, $tran);
            }
        }

        $current = [];
        foreach ($trans as $tran) {
            if ($tran->is_received && $tran->order->is_payed) {
                $current = array_prepend($current, $tran);
            }
        }

        $past = [];
        foreach ($trans as $tran) {
            if (!$tran->is_received && $tran->order->end_date < Carbon::yesterday() && $tran->order->is_payed) {
                $past = array_prepend($past, $tran);
            }
        }

        $relatedOrders = Order::where('is_payed', true)->inRandomOrder()->limit(10)->get();

        return view('tran.index', compact('pre', 'current', 'past', 'relatedOrders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::find(request('order_id'));
        if ($order->trans) {
            return redirect()->back();
        } else {
            $entry = Tran::create([
                'user_id' => auth()->user()->id,
                'order_id' => $order->id,
            ]);
        }

        \Mail::to($order->user)->send(new OrderAccepted($order->user, $order));

        return redirect()->action('TranController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tran  $tran
     * @return \Illuminate\Http\Response
     */
    public function show(Tran $tran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tran  $tran
     * @return \Illuminate\Http\Response
     */
    public function edit(Tran $tran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tran  $tran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tran $tran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tran  $tran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tran $tran)
    {
        //
    }
}
