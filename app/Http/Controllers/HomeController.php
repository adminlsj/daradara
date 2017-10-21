<?php

namespace App\Http\Controllers;

use App\Order;
use App\Mail\Contact;
use App\Mail\Meetup;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //auth()->loginUsingId(1);
        $makeups = Order::where(['is_payed' => 1, 'category' => 'makeup'])->get();
        $foods = Order::where(['is_payed' => 1, 'category' => 'food'])->get();
        $bags = Order::where(['is_payed' => 1, 'category' => 'bag'])->get();
        $accessories = Order::where(['is_payed' => 1, 'category' => 'accessories'])->get();
        $watches = Order::where(['is_payed' => 1, 'category' => 'watch'])->get();
        $others = Order::where(['is_payed' => 1, 'category' => 'others'])->get();

        $loopOrders = ['makeup' => $makeups, 'food' => $foods, 'bag' => $bags, 'accessories' => $accessories, 'watch' => $watches, 'others' => $others];

        return view('layouts.home', compact('orders', 'loopOrders'));
    }

    public function contact()
    {
        return view('layouts.contact');
    }

    public function sendMail(String $status)
    {
        switch ($status) {
            case 'contact':
                $user_email = request('email');
                $title = request('title');
                $text = request('text');
                \Mail::to('freeriderhk852@gmail.com')->send(new Contact($user_email, $title, $text));
                break;

            case 'meetup':
                $user_email = request('email');
                $location = request('location');
                $time = request('time');
                \Mail::to('freeriderhk852@gmail.com')->send(new Meetup($user_email, $location, $time));
                break;
            
            default:
                break;
        }
        return redirect('/');
    }

    public function manual()
    {
        return view('layouts.manual');
    }
}
