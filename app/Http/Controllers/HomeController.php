<?php

namespace App\Http\Controllers;

use App\Company;
use App\Job;
use App\Blog;
use App\Mail\Contact;
use App\Mail\ContactUser;
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

        $blogs = Blog::all()->sortByDesc('created_at');
        $caro_blogs = Blog::inRandomOrder()->limit(4)->get();
        $relatedBlogs = Blog::inRandomOrder()->limit(3)->get();
        $similar_blogs = Blog::inRandomOrder()->limit(5)->get();

        $featuredCompanies = ['騰訊', '阿里巴巴', '小米', '百度', '鏈家', '滴滴'];
        $featuredAgencies = ['exmil', 'ern', 'freerider'];

        return view('layouts.home', compact('blogs', 'caro_blogs', 'relatedBlogs', 'similar_blogs', 'featuredCompanies', 'featuredAgencies'));
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
            
            default:
                break;
        }
        return redirect('/');
    }
}
