<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Anime;
use App\Character;
use App\Episodes;
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

class ActorController extends Controller
{
    public function show(Request $request, Actor $actor)
    {
        $animes = $actor->animes;
        return view('actor.show', compact('animes', 'actor'));
    }
}