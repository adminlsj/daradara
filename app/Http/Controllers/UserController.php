<?php

namespace App\Http\Controllers;

use App\User;
use App\Savelist;
use App\Video;
use App\Watch;
use App\Save;
use App\Like;
use App\Subscribe;
use App\Playlist;
use App\Playitem;
use Illuminate\Http\Request;
use Image;
use Auth;
use Redirect;
use Carbon\Carbon;
use App\Helper;
use Doctrine\DBAL\Schema\View;
use Illuminate\Support\Facades\Storage;
use SteelyWing\Chinese\Chinese;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->only('animelist');
        // $this->middleware('user.save')->only('edit', 'update', 'destroy', 'storeAvatar', 'userEditUpload', 'userUpdateUpload');
    }

    public function animelist(Request $request, User $user)
    {
        $anime_lists = $user->anime_lists->load('anime_saves.anime', 'anime_saves.savelists');
        $anime_statuslists = $user->anime_statuslists->load('anime_saves.anime', 'anime_saves.savelists');
        $chinese = new Chinese();
        return view('user.animeList.index', compact('user', 'anime_lists', 'anime_statuslists', 'chinese'));
    }

    public function animelistShow(Request $request, User $user, String $name, Savelist $savelist, String $title)
    {   
        $anime_lists = $user->anime_lists->load('anime_saves.anime');
        $anime_statuslists = $user->anime_statuslists->load('anime_saves.anime');
        $anime_saves = $savelist->anime_saves->load('anime');
        $chinese = new Chinese();
        return view('user.animeList.show', compact('user', 'anime_lists', 'anime_statuslists', 'savelist', 'anime_saves', 'chinese'));
    }

    public function likes(Request $request, User $user)
    {
        $anime_likes = $user->likes('App\Anime')->with('anime')->get();
        $character_likes = $user->likes('App\Character')->with('character')->get();
        $staff_likes = $user->likes('App\Staff')->with('staff')->get();
        $company_likes = $user->likes('App\Company')->with('company')->get();
        $chinese = new Chinese();
        return view('like.index', compact('user', 'anime_likes', 'character_likes', 'staff_likes', 'company_likes', 'chinese'));
    }
}
