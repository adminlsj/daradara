<?php

namespace App\Http\Controllers;

use App\Staff;
use App\Anime;
use App\Character;
use App\AnimeCharacterRole;
use App\Episodes;
use App\User;
use App\Like;
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

class StaffController extends Controller
{
    public function show(Request $request, Staff $staff)
    {
        $animes_actor = $staff->animes('actor')->with(['characters' => function($query) use ($staff) {
                                    $query->where('staff_id', $staff->id);
                                }])->distinct()->orderBy('started_at', 'desc')->orderBy('rating_mal_count', 'desc')->get();
        $animes_staff = $staff->animes('staff')->get();

        $chinese = new Chinese();

        return view('staff.show', compact('staff', 'animes_actor', 'animes_staff', 'chinese'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'max:255',
        ]);

        $results = Staff::query();

        if ($text = $request->text) {
            $query = $text;
            $query = mb_strtolower($query, 'UTF-8');
            $query = str_replace(' ', '%', $query);
            $chinese = new Chinese();
            $original = '%'.$query.'%';
            $zh_hant = '%'.$chinese->to(Chinese::ZH_HANT, $query).'%';
            $zh_hans = '%'.$chinese->to(Chinese::ZH_HANS, $query).'%';
            $results = $results->where(function($query) use ($original, $zh_hant, $zh_hans) {
                $query->where('searchtext', 'like', $original)
                      ->orWhere('searchtext', 'like', $zh_hant)
                      ->orWhere('searchtext', 'like', $zh_hans);
            });
        }

        $results = $results->distinct()->paginate(30);

        $results->setPath('');

        $chinese = new Chinese();
        return view('staff.search', compact('results', 'text', 'chinese'));
    }
}