<?php

namespace App\Http\Controllers;

use App\Company;
use App\Job;
use App\Blog;
use App\Mail\Contact;
use App\Mail\ContactUser;
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
        $companies = Company::all();

        $blogs = Blog::all()->sortByDesc('created_at');
        $caro_blogs = Blog::inRandomOrder()->limit(4)->get();
        $relatedBlogs = Blog::inRandomOrder()->limit(3)->get();
        $similar_blogs = Blog::inRandomOrder()->limit(5)->get();

        $featuredCompanies = ['騰訊', '阿里巴巴', '小米', '百度', '華為', '滴滴'];
        $featuredAgencies = ['exmil', 'ern', 'freerider'];

        return view('layouts.home', compact('companies', 'blogs', 'caro_blogs', 'relatedBlogs', 'similar_blogs', 'featuredCompanies', 'featuredAgencies'));
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
                \Mail::to('u3514481@connect.hku.hk')->send(new Contact($user_email, $title, $text));
                \Mail::to(request('email'))->send(new ContactUser($user_email, $title, $text));
                break;

            case 'meetup':
                $user_email = request('email');
                $location = request('location');
                $time = request('time');
                \Mail::to('u3514481@connect.hku.hk')->send(new Meetup($user_email, $location, $time));
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
