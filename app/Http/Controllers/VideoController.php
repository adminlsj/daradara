<?php

namespace App\Http\Controllers;

use App\Video;
use App\Watch;
use App\User;
use App\Comment;
use App\Reply;
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

        $video = Video::with('watch:id,title')->select('id', 'user_id', 'playlist_id', 'title', 'translations', 'caption', 'cover', 'tags', 'sd', 'outsource', 'current_views', 'views', 'imgur', 'foreign_sd', 'duration', 'created_at', 'uploaded_at')->withCount('likes')->find($request->v);

        $watch = Watch::where('id', $video->playlist_id)->select('id', 'title')->withCount('videos')->first();

        if ($video->cover == null || ($video->foreign_sd != null && array_key_exists('redirect', $video->foreign_sd))) {
            header("Location: https://www.laughseejapan.com".$request->getRequestUri());
            die();
        }

        $videos = Video::with('user:id,name')->where('playlist_id', $video->playlist_id)->orderBy('created_at', 'desc')->select('id', 'user_id', 'imgur', 'title', 'sd', 'views', 'created_at')->get();

        $tags = array_intersect($video->tags(), Video::$selected_tags);
        $video->current_views++;
        $video->views++;
        $video->save();
        $current = $video;

        $related = Video::with('user:id,name')->where(function($query) use ($current) {
            foreach ($current->tags() as $tag) {
                if (in_array($tag, Video::$selected_tags)) {
                    $query->orWhere('tags', 'like', '%'.$tag.'%');
                }
            }
        })->where('cover', '!=', null)->where('imgur', '!=', 'CJ5svNv')->where('playlist_id', '!=', $current->playlist_id)->inRandomOrder()->select('id', 'user_id', 'cover', 'imgur', 'title', 'sd', 'views', 'created_at')->limit(60)->get();

        $country_code = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : 'N/A';

        $comments = Comment::with('user.avatar', 'likes', 'replies.likes', 'replies.user.avatar')->where('foreign_id', $video->id)->orderBy('created_at', 'desc')->get();

        return view('video.watch-new', compact('video', 'watch', 'videos', 'current', 'tags', 'country_code', 'comments', 'related'));
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
        $html = '';
        $html .= view('video.likeBtn', compact('video'));

        return response()->json([
            'likeBtn' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function save(Request $request)
    {
        $user_id = request('save-user-id');
        $video_id = request('save-video-id');

        if (Save::where('user_id', $user_id)->where('video_id', $video_id)->first() == null) {
            $save = Save::create([
                'user_id' => $user_id,
                'video_id' => $video_id,
            ]);
        }

        $video = Video::find($video_id);
        $html = '';
        $html .= view('video.unsaveBtn', compact('video'));

        return response()->json([
            'unsaveBtn' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function unsave(Request $request)
    {
        $user_id = request('save-user-id');
        $video_id = request('save-video-id');

        $save = Save::where('user_id', $user_id)->where('video_id', $video_id)->first();
        if ($save != null) {
            $save->delete();
        }

        $video = Video::find($video_id);
        $html = '';
        $html .= view('video.saveBtn', compact('video'));

        return response()->json([
            'saveBtn' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function createComment(Request $request)
    {
        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'type' => request('comment-type'),
            'foreign_id' => request('comment-foreign-id'),
            'text' => request('comment-text'),
        ]);

        if (request('comment-type') == 'video') {
            $html = '';
            $html .= view('video.singleVideoComment', compact('comment'));

        } elseif (request('comment-type') == 'comment') {
            $comment_reply = $comment;
            $comment = Comment::find(request('comment-foreign-id'));
            $html = '';
            $html .= view('video.single-comment-reply', compact('comment', 'comment_reply'));
        }

        $comment_count = $comment->video()->comments()->count();

        return response()->json([
            'comment_id' => $comment->id,
            'comment_count' => $comment_count,
            'single_video_comment' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function commentLike(Request $request)
    {
        $user_id = Auth::user()->id;
        $foreign_type = request('foreign_type');
        $foreign_id = request('foreign_id');
        $is_positive = request('is_positive');

        if ($like = Like::where('user_id', $user_id)->where('foreign_type', $foreign_type)->where('foreign_id', $foreign_id)->where('is_positive', true)->first()) {
            $like->delete();
        } else {
            $like = Like::create([
                'user_id' => $user_id,
                'foreign_type' => $foreign_type,
                'foreign_id' => $foreign_id,
                'is_positive' => $is_positive,
            ]);
        }

        $model = 'App\\'.studly_case(strtolower(str_singular($foreign_type)));
        $comment = (new $model)::find($foreign_id);
        $html = '';
        $html .= view('video.comment-like-btn', compact('comment'));

        return response()->json([
            'comment_id' => $comment->id,
            'comment_like_btn' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function commentUnlike(Request $request)
    {
        $user_id = Auth::user()->id;
        $foreign_type = request('foreign_type');
        $foreign_id = request('foreign_id');

        if ($like = Like::where('user_id', $user_id)->where('foreign_type', $foreign_type)->where('foreign_id', $foreign_id)->where('is_positive', false)->first()) {
            $like->delete();
        } else {
            $like = Like::create([
                'user_id' => $user_id,
                'foreign_type' => $foreign_type,
                'foreign_id' => $foreign_id,
                'is_positive' => false,
            ]);
        }

        $model = 'App\\'.studly_case(strtolower(str_singular($foreign_type)));
        $comment = (new $model)::find($foreign_id);
        $html = '';
        $html .= view('video.comment-unlike-btn', compact('comment'));

        return response()->json([
            'comment_id' => $comment->id,
            'comment_unlike_btn' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function replyComment(Request $request)
    {
        $reply = Reply::create([
            'user_id' => auth()->user()->id,
            'comment_id' => request('reply-comment-id'),
            'text' => request('reply-comment-text'),
        ]);

        $comment = Comment::find($reply->comment_id);
        $html = '';
        $html .= view('video.single-comment-reply', compact('comment', 'reply'));

        return response()->json([
            'comment_id' => $comment->id,
            'single_video_comment' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }
}
