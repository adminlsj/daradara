<?php

namespace App\Http\Controllers;

use App\Video;
use App\Watch;
use App\User;
use App\Subscribe;
use App\Like;
use App\Save;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Auth;
use Carbon\Carbon;
use Response;
use SteelyWing\Chinese\Chinese;

class VideoController extends Controller
{
    public function watch(Request $request){
        $vid = $request->v;
        if (is_numeric($vid) && $video = Video::with('user:id,name', 'likes:id,foreign_id,user_id', 'saves:id,user_id,video_id')->select('id', 'user_id', 'playlist_id', 'title', 'translations', 'caption', 'cover', 'tags', 'imgur', 'sd')->find($request->v)) {

            $excluded = Video::getExcludedIds();

            if ($video->cover == null) {
                header("Location: https://www.laughseejapan.com".$request->getRequestUri());
                die();
            }

            $videos = Video::where('playlist_id', $video->playlist_id)->orderBy('created_at', 'desc')->select('id', 'title', 'cover')->get();

            $tags = array_intersect($video->tags(), Video::$selected_tags);
            $recommends = Video::where(function($query) use ($tags) {
                foreach ($tags as $tag) {
                    $query->orWhere('tags', 'ilike', '%'.$tag.'%');
                }
            })->whereIntegerNotInRaw('id', $videos->pluck('id'))->whereIntegerNotInRaw('id', $excluded)->where('cover', '!=', null)->select('id', 'title', 'cover')->inRandomOrder()->limit(42)->get();

            $video->views++;
            $video->save();

            return view('video.watch', compact('video', 'videos', 'recommends', 'tags'));
        }
    }

    public function like(Request $request)
    {
        $user_id = request('like-user-id');
        $foreign_type = request('like-foreign-type');
        $foreign_id = request('like-foreign-id');
        $is_positive = request('like-is-positive');

        if ($like = Like::where('user_id', $user_id)->where('foreign_type', $foreign_type)->where('foreign_id', $foreign_id)->where('is_positive', $is_positive)->first()) {
            $like->delete();

        } else {
            $like = Like::create([
                'user_id' => $user_id,
                'foreign_type' => $foreign_type,
                'foreign_id' => $foreign_id,
                'is_positive' => $is_positive,
            ]);
        }

        $video = Video::find($foreign_id);

        $desktop = '';
        $desktop .= view('video.info-desktop-like-btn', compact('video'));

        $mobile = '';
        $mobile .= view('video.info-mobile-like-btn', compact('video'));

        return response()->json([
            'desktop' => $desktop,
            'mobile' => $mobile,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function save(Request $request)
    {
        $user_id = request('save-user-id');
        $video_id = request('save-video-id');

        if ($save = Save::where('user_id', $user_id)->where('video_id', $video_id)->first()) {
            $save->delete();
        } else {
            $save = Save::create([
                'user_id' => $user_id,
                'video_id' => $video_id,
            ]);
        }

        $video = Video::find($video_id);

        $desktop = '';
        $desktop .= view('video.info-desktop-save-btn', compact('video'));

        $mobile = '';
        $mobile .= view('video.info-mobile-save-btn', compact('video'));

        return response()->json([
            'desktop' => $desktop,
            'mobile' => $mobile,
            'csrf_token' => csrf_token(),
        ]);
    }
}
