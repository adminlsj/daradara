<?php

namespace App\Http\Controllers;

use App\User;
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

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->only('animelist');
        // $this->middleware('user.save')->only('edit', 'update', 'destroy', 'storeAvatar', 'userEditUpload', 'userUpdateUpload');
    }

    public function animelist(Request $request, User $user)
    {
        $anime_lists = $user->anime_lists->load('anime_saves.anime');
        $anime_statuslists = $user->anime_statuslists->load('anime_saves.anime');
        return view('user.show.animeList', compact('user', 'anime_lists', 'anime_statuslists'));
    }

    public function likes(Request $request, User $user)
    {
        return view('user.show.likes', compact('user'));
    }
}
