<?php

namespace App\Http\Controllers;

use App\User;
use App\Anime;
use Illuminate\Http\Request;
use Response;
use Auth;
use Mail;
use App\Mail\UserReport;
use Redirect;
use Storage;
use App\Helper;
use SteelyWing\Chinese\Chinese;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        //$animes = Anime::orderby('id', 'desc')->paginate(60);
        $animes = Anime::orderby('id', 'asc')->paginate(5);
        return view('layouts.home', compact('animes'));
    }
}
