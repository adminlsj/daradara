<?php

namespace App\Http\Controllers;

use App\Anime;
use App\AnimeSave;
use App\Character;
use App\Episodes;
use App\User;
use Illuminate\Http\Request;
use Response;
use Auth;
use Mail;
use Redirect;
use Storage;
use App\Helper;
use SteelyWing\Chinese\Chinese;
use Illuminate\Database\Eloquent\Builder;

class AnimeController extends Controller
{
    public function show(Request $request, Anime $anime)
    {
        $episodes = Episodes::where('anime_id', $anime->id)->orderBy('id')->get();
        $characters = $anime->characters->load('actors');
        $anime_save = null;
        if ($user = Auth::user()) {
            $anime_save = AnimeSave::where('user_id', $user->id)->where('anime_id', $anime->id)->first();
        }
        return view('anime.show', compact('anime', 'anime_save', 'characters', 'episodes'));
    }

    public function save(Request $request, Anime $anime)
    {
        $user = Auth::user();
        if ($anime_save = AnimeSave::where('user_id', $user->id)->where('anime_id', $anime->id)->first()) {
            $anime_save->episode_progress = $request->episode_progress;
            $anime_save->start_date = $request->start_date;
            $anime_save->finish_date = $request->finish_date;
            $anime_save->total_rewatches = $request->total_rewatches;
            $anime_save->notes = $request->notes;
            $anime_save->is_hidden_from_status_lists = $request->is_hidden_from_status_lists ? true : false;
            $anime_save->save();

        } else {
            $anime_save = AnimeSave::create([
                'user_id' => $user->id,
                'anime_id' => $anime->id,
                'episode_progress' => $request->episode_progress,
                'start_date' => $request->start_date,
                'finish_date' => $request->finish_date,
                'total_rewatches' => $request->total_rewatches,
                'notes' => $request->notes,
                'is_hidden_from_status_lists' => $request->is_hidden_from_status_lists ? true : false,
            ]);
        }

        return Redirect::route('anime.show', ['anime' => $anime, 'title' => $anime->title]);
    }
}