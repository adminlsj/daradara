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

class CharacterController extends Controller
{
    public function show(Request $request, Character $character)
    {
        $animes = $character->animes;
        return view('character.show', compact('animes', 'character'));
    }
}