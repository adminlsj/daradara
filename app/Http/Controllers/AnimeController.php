<?php

namespace App\Http\Controllers;

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

class AnimeController extends Controller
{
    public function show(Request $request, Anime $anime)
    {
        //$character = Character::where('anime_id', $anime->id)->get();
        $episodes = Episodes::where('anime_id', $anime->id)->orderBy('id')->get();
        $characters = $anime->characters;
        return view('anime.show', compact('anime', 'characters', 'episodes'));
    }
}