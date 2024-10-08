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
        $anime_lists = $user->anime_lists;
        return view('user.animelist.show', compact('user', 'anime_lists'));
    }
}
