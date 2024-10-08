<?php

namespace App\Http\Controllers;

use App\User;
use App\Savelist;
use Illuminate\Http\Request;
use Image;
use Auth;
use Redirect;
use Carbon\Carbon;
use App\Helper;
use Illuminate\Support\Facades\Storage;

class SavelistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
        $this->middleware('user.same')->only('store');
    }

    public function store(Request $request, User $user)
    {
        Savelist::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'is_status' => $request->is_status,
            'is_private' => $request->is_private ? true : false,
            'type' => $request->type,
        ]);

        return Redirect::route('user.animelist', ['user' => $user, 'name' => $user->name]);
    }
}
