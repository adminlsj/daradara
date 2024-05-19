<?php

namespace App\Http\Controllers;

use App\Anime;
use App\User;
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

class AnimeController extends Controller
{
    public function show(Request $request, Anime $anime)
    {
        return view('anime.show', compact('anime'));
    }
}