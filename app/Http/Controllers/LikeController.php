<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use Response;
use Auth;
use Redirect;
use Session;
use App\Helper;
use SteelyWing\Chinese\Chinese;
use Illuminate\Database\Eloquent\Builder;

class LikeController extends Controller
{
    public function create(Request $request, $type, $id)
    {
        $user = Auth::user();
        if ($like = Like::where('user_id', $user->id)->where('likeable_id', $id)->where('likeable_type', $type)->first()) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => $user->id,
                'likeable_id' => $id,
                'likeable_type' => $type
            ]);
        }

        $chinese = new Chinese();

        return Redirect::intended($request->redirectTo);
    }
}