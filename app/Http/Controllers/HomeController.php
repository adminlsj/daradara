<?php

namespace App\Http\Controllers;

use App\Order;
use App\Blog;
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
        $makeups = Order::where(['is_payed' => 1, 'category' => 'makeup'])->inRandomOrder()->limit(20)->get();
        $foods = Order::where(['is_payed' => 1, 'category' => 'food'])->inRandomOrder()->limit(20)->get();
        $bags = Order::where(['is_payed' => 1, 'category' => 'bag'])->inRandomOrder()->limit(20)->get();
        $accessories = Order::where(['is_payed' => 1, 'category' => 'accessories'])->inRandomOrder()->limit(20)->get();
        $watches = Order::where(['is_payed' => 1, 'category' => 'watch'])->inRandomOrder()->limit(20)->get();
        $others = Order::where(['is_payed' => 1, 'category' => 'others'])->inRandomOrder()->limit(20)->get();

        $blogs = Blog::all()->sortByDesc('created_at');
        $caro_blogs = Blog::inRandomOrder()->limit(4)->get();
        $relatedBlogs = Blog::inRandomOrder()->limit(3)->get();

        $loopOrders = ['food' => $foods, 'makeup' => $makeups, 'bag' => $bags, 'accessories' => $accessories, 'watch' => $watches, 'others' => $others];

        return view('layouts.home', compact('orders', 'loopOrders', 'caro_blogs', 'relatedBlogs'));
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
