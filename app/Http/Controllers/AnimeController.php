<?php

namespace App\Http\Controllers;

use App\Anime;
use App\AnimeSave;
use App\AnimeCharacterRole;
use App\Savelist;
use App\Savelistable;
use App\Character;
use App\Staff;
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
    public function __construct()
    {
        $this->middleware('auth')->only('save');
    }

    public function show(Request $request, Anime $anime)
    {
        $episodes = Episodes::where('anime_id', $anime->id)->orderBy('id')->get();
        $characters = $anime->characters->load('actors');
        $staffs = $anime->staffs;
        $anime_save = null;
        $status = null;
        $anime_lists = [];
        $saved_lists = [];
        if ($user = Auth::user()) {
            $anime_lists = $user->anime_lists;
            if ($anime_save = $user->anime_save($anime->id)) {
                $status = $anime_save->status;
                $saved_lists = $anime_save->savelists->pluck('id')->toArray();
            }
        }
        return view('anime.show', compact('anime', 'anime_save', 'anime_lists', 'saved_lists', 'status', 'characters', 'episodes', 
            'staffs'));
    }

    public function save(Request $request, Anime $anime)
    {
        $user = Auth::user();

        // Update anime_save details
        if ($anime_save = $user->anime_save($anime->id)) {
            $anime_save->status = $request->status;
            $anime_save->episode_progress = $request->episode_progress;
            $anime_save->start_date = $request->start_date;
            $anime_save->finish_date = $request->finish_date;
            $anime_save->total_rewatches = $request->total_rewatches;
            $anime_save->notes = $request->notes;
            $anime_save->is_hidden_from_status_lists = $request->is_hidden_from_status_lists ? true : false;
            $anime_save->save();

            $saved_animelists = $anime_save->savelists;
            $selected_animelists = $request->animelists ? $request->animelists : [];

            // Delete only un-selected animelists
            $delete_savelistables = [];
            foreach ($saved_animelists as $saved_animelist) {
                if (!in_array($saved_animelist->id, $selected_animelists)) {
                    array_push($delete_savelistables, $saved_animelist->pivot->id);
                }
            }
            Savelistable::whereIn('id', $delete_savelistables)->delete();

            // Create newly selected animelists
            $saved_animelists_ids = $saved_animelists->pluck('id')->toArray();
            foreach ($selected_animelists as $selected_animelist) {
                if (!in_array($selected_animelist, $saved_animelists_ids)) {
                    Savelistable::create([
                        'savelist_id' => $selected_animelist,
                        'savelistable_id' => $anime_save->id,
                        'savelistable_type' => 'App\AnimeSave'
                    ]);
                }
            }

        // Create new anime_save
        } else {
            $anime_save = AnimeSave::create([
                'user_id' => $user->id,
                'anime_id' => $anime->id,
                'status' => $request->status,
                'episode_progress' => $request->episode_progress,
                'start_date' => $request->start_date,
                'finish_date' => $request->finish_date,
                'total_rewatches' => $request->total_rewatches,
                'notes' => $request->notes,
                'is_hidden_from_status_lists' => $request->is_hidden_from_status_lists ? true : false,
            ]);

            $animelists = $request->animelists;
            foreach ($animelists as $animelist) {
                Savelistable::create([
                    'savelist_id' => $animelist,
                    'savelistable_id' => $anime_save->id,
                    'savelistable_type' => 'App\AnimeSave'
                ]);
            }
        }

        return Redirect::route('anime.show', ['anime' => $anime, 'title' => $anime->title]);
    }
}