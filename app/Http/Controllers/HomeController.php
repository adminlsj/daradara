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
        $orders = Order::where('is_payed', 1);
        $makeups = Order::where(['is_payed' => 1, 'category' => 'makeup'])->get();
        $foods = Order::where(['is_payed' => 1, 'category' => 'food'])->get();
        $fashions = Order::where(['is_payed' => 1, 'category' => 'fashion'])->get();
        $electronics = Order::where(['is_payed' => 1, 'category' => 'electronic'])->get();
        $entertainments = Order::where(['is_payed' => 1, 'category' => 'entertainment'])->get();
        $others = Order::where(['is_payed' => 1, 'category' => 'others'])->get();
        return view('layouts.home', compact('orders', 'makeups', 'foods', 'fashions', 'electronics', 'entertainments', 'others'));
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
