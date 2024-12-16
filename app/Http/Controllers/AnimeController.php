<?php

namespace App\Http\Controllers;

use App\Anime;
use App\AnimeSave;
use App\AnimeCharacterRole;
use App\Savelist;
use App\Savelistable;
use App\Like;
use App\Character;
use App\Staff;
use App\Episode;
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
        $related_animes = $anime->related_animes->sortBy(function ($related_anime) {
                                if ($related_anime->started_at) {
                                    return $related_anime->started_at;
                                } else {
                                    return true;
                                }
                            });
        $episodes = Episode::where('anime_id', $anime->id)->orderBy('id')->get();
        $characters = $anime->characters->load('actors');
        $staffs = $anime->staffs;
        $year = $anime->created_at->format('Y');
        $recommendations = Anime::whereYear('created_at', $year)->inRandomOrder()->limit(5)->get();
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

        $chinese = new Chinese();

        return view('anime.show', compact('anime', 'anime_save', 'anime_lists', 'saved_lists', 'status', 'related_animes', 'characters', 'episodes', 'staffs', 'recommendations', 'chinese'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'max:255',
        ]);

        $results = Anime::query();

        if ($text = $request->text) {
            $query = $text;
            $query = mb_strtolower($query, 'UTF-8');
            $query = str_replace(' ', '%', $query);
            $chinese = new Chinese();
            $zh_hant = '%'.$chinese->to(Chinese::ZH_HANT, $query).'%';
            $zh_hans = '%'.$chinese->to(Chinese::ZH_HANS, $query).'%';
            $results = $results->where(function($query) use ($zh_hant, $zh_hans) {
                $query->where('searchtext', 'like', $zh_hant)
                      ->orWhere('searchtext', 'like', $zh_hans);
            });
        }

        if ($year = $request->year) {
            $results = $results->whereYear('started_at', $year);
        }

        if ($season = $request->season) {
            switch ($season) {
                case '1月冬番':
                    $results = $results->whereMonth('started_at', '>=', 1)->whereMonth('started_at', '<=', 3);
                    break;

                case '4月春番':
                    $results = $results->whereMonth('started_at', '>=', 4)->whereMonth('started_at', '<=', 6);
                    break;

                case '7月夏番':
                    $results = $results->whereMonth('started_at', '>=', 7)->whereMonth('started_at', '<=', 9);
                    break;

                case '10月秋番':
                    $results = $results->whereMonth('started_at', '>=', 10)->whereMonth('started_at', '<=', 12);
                    break;
                
                default:
                    break;
            }
        }

        if ($category = $request->category) {
            $results = $results->where('category', $category);
        }

        if ($sort = $request->sort) {
            switch ($sort) {
                case '標題':
                    $results = $results->orderBy('title_jp', 'desc');
                    break;

                case '人氣':
                    // rating_mal_count
                    $results = $results->orderBy('rating_mal', 'desc');
                    break;

                case '評分':
                    $results = $results->orderBy('rating_mal', 'desc');
                    break;

                case '流行':
                    $results = $results->orderBy('rating_mal', 'desc');
                    break;

                case '讚好':
                    $results = $results->orderBy('rating_mal', 'desc');
                    break;

                case '上傳日期':
                    $results = $results->orderBy('created_at', 'desc');
                    break;

                case '上市日期':
                    $results = $results->orderBy('started_at', 'desc');
                    break;

                default:
                    break;
            }
        }

        if ($airing_status = $request->airing_status) {
            $results = $results->where('airing_status', $airing_status);
        }

        if ($streaming_on = $request->streaming_on) {
            $results = $results;
        }

        if ($country = $request->country) {
            $results = $results;
        }

        if ($source = $request->source) {
            $results = $results;
        }

        $results = $results->distinct()->paginate(30);

        $results->setPath('');

        $chinese = new Chinese();

        $is_mobile = Helper::checkIsMobile();

        return view('home.search', compact('sort', 'year', 'season', 'results', 'is_mobile', 'chinese', 'category', 'airing_status', 'streaming_on', 'country', 'source', 'text'));
    }

    public function save(Request $request, Anime $anime)
    {
        $user = Auth::user();

        // Update anime_save details
        if ($anime_save = $user->anime_save($anime->id)) {
            $anime_save->episode_progress = $request->episode_progress;
            $anime_save->start_date = $request->start_date;
            $anime_save->finish_date = $request->finish_date;
            $anime_save->total_rewatches = $request->total_rewatches;
            $anime_save->notes = $request->notes;
            $anime_save->is_hidden_from_status_lists = $request->is_hidden_from_status_lists ? true : false;

            $saved_animelists = $anime_save->savelists;
            if ($anime_save->status == $request->status) {
                $saved_animelists = $saved_animelists->where('is_status', false);
            } else {
                // Create newly selected statuslist
                $statuslist = $user->anime_statuslist($request->status);
                Savelistable::create([
                    'savelist_id' => $statuslist->id,
                    'savelistable_id' => $anime_save->id,
                    'savelistable_type' => 'App\AnimeSave'
                ]);
                $anime_save->status = $request->status;
            }
            $anime_save->save();
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

            // Create Savelistable for statuslist
            $statuslist = $user->anime_statuslist($request->status);
            Savelistable::create([
                'savelist_id' => $statuslist->id,
                'savelistable_id' => $anime_save->id,
                'savelistable_type' => 'App\AnimeSave'
            ]);

            // Create Savelistable for animelists
            if ($animelists = $request->animelists) {
                foreach ($animelists as $animelist) {
                    Savelistable::create([
                        'savelist_id' => $animelist,
                        'savelistable_id' => $anime_save->id,
                        'savelistable_type' => 'App\AnimeSave'
                    ]);
                }
            }
        }

        $chinese = new Chinese();

        $redirectTo = $request->redirectTo;
        if ($redirectTo == 'user.animelist') {
            return Redirect::route('user.animelist', ['user' => $user, 'name' => $user->name]);

        } elseif (strpos($redirectTo, 'user.animelist.show') !== false) {
            $redirectTo = str_replace('user.animelist.show.', '', $redirectTo);
            $data = explode('.', $redirectTo);
            $savelist = $data[0];
            $title = $data[1];
            return Redirect::route('user.animelist.show', ['user' => $user, 'name' => $user->name, 'savelist' => $savelist, 'title' => $title]);

        } else {
            return Redirect::route('anime.show', ['anime' => $anime, 'title' => $anime->getTitle($chinese)]);
        }
    }

    public function like(Request $request, Anime $anime)
    {
        $user = Auth::user();
        if ($like = Like::where('user_id', $user->id)->where('likeable_id', $anime->id)->where('likeable_type', 'App\Anime')->first()) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => $user->id,
                'likeable_id' => $anime->id,
                'likeable_type' => 'App\Anime'
            ]);
        }

        $chinese = new Chinese();

        return Redirect::route('anime.show', ['anime' => $anime, 'title' => $anime->getTitle($chinese)]);
    }
}