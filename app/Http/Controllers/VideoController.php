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
use Auth;
use Carbon\Carbon;
use SteelyWing\Chinese\Chinese;
use App\Helper;
use Redirect;
use Validator;

class VideoController extends Controller
{
    public function watch(Request $request)
    {
        $vid = $request->v;

        if (is_numeric($vid) && $video = Video::with('watch:id,title')->select('id', 'user_id', 'playlist_id', 'comic_id', 'title', 'translations', 'caption', 'cover', 'tags_array', 'sd', 'qualities', 'outsource', 'has_subtitles', 'current_views', 'views', 'imgur', 'foreign_sd', 'duration', 'created_at', 'uploaded_at')->withCount('likes')->find($vid)) {

            $current = $video;
            $doujin = false;
            $is_mobile = Helper::checkIsMobile();

            $video->current_views++;
            $video->views++;
            $video->save();

            $videos = Video::where('playlist_id', $video->playlist_id)->orderBy('created_at', 'desc')->select('id', 'user_id', 'imgur', 'title', 'sd', 'views', 'created_at')->get();

            $tags = $tags_random = array_keys($video->tags_array);
            $include = array_values(array_intersect(Video::$include, $tags_random));
            $include = array_slice($include, 0, 5);
            $tags_random = array_values(array_diff($tags_random, $include));
            $tags_random = array_values(array_diff($tags_random, $exclude));
            shuffle($tags_random);
            $tags_slice = array_slice($tags_random, 0, 5 - count($include));
            $tags_slice = array_merge($tags_slice, $include);

            $related = Video::query();
            $related = $related->where(function($query) use ($tags, &$doujin) {
                if (in_array('3D', $tags)) {
                    $doujin = true;
                    $query->orWhere('tags_array', 'like', '%"3D"%');
                }
                if (in_array('同人', $tags)) {
                    $doujin = true;
                    $query->orWhere('tags_array', 'like', '%"同人"%');
                }
                if (in_array('Cosplay', $tags)) {
                    $doujin = true;
                    $query->orWhere('tags_array', 'like', '%"Cosplay"%');
                }
            });
            $related = $related->where(function($query) use ($tags_slice) {
                foreach ($tags_slice as $tag) {
                    $query->orWhere('tags_array', 'like', '%"'.$tag.'"%');
                }
            });

            if ($doujin == true) {
                $related = $related->with('user:id,name,avatar_temp')->where('cover', '!=', null)->where('id', '!=', $current->id)->inRandomOrder()->select('id', 'user_id', 'cover', 'imgur', 'title', 'sd', 'qualities', 'views', 'duration', 'created_at')->limit(60)->get();

            } else {
                $related = $related->where('cover', '!=', null)->where('cover', '!=', 'https://i.imgur.com/E6mSQA2.png')->where('playlist_id', '!=', $current->playlist_id)->inRandomOrder()->select('id', 'user_id', 'cover', 'imgur', 'title', 'sd', 'qualities', 'views', 'created_at')->limit(60)->get();
            }

            $country_code = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : 'N/A';

            $comments_count = Comment::where('foreign_id', $video->id)->count();

            if (Auth::check()) {
                $saved = Save::where('user_id', auth()->user()->id)->where('video_id', $video->id)->exists();
                $liked = Like::where('user_id', Auth::user()->id)->where('foreign_type', 'video')->where('foreign_id', $video->id)->exists();
            } else {
                $saved = false;
                $liked = false;
            }

        } else {
            abort(403);
        }

        return view('video.watch-new', compact('video', 'videos', 'current', 'tags', 'country_code', 'comments_count', 'related', 'doujin', 'is_mobile', 'saved', 'liked'));
    }

    public function download(Request $request)
    {
        $is_mobile = Helper::checkIsMobile();
        $video = Video::select('id', 'user_id', 'playlist_id', 'title', 'translations', 'caption', 'cover', 'tags', 'sd', 'qualities', 'outsource', 'current_views', 'views', 'imgur', 'foreign_sd', 'duration', 'created_at', 'uploaded_at')->find($request->v);

        if ($video->qualities == null) {
            abort(403);
        }

        return view('video.download', compact('video', 'is_mobile'));
    }

    public function like(Request $request)
    {
        $user_id = request('like-user-id');
        $video_id = request('like-foreign-id');
        $is_positive = request('like-is-positive');
        $liked = request('like-status');

        if ($liked) {
            Like::where('user_id', $user_id)
                ->where('foreign_type', 'video')
                ->where('foreign_id', $video_id)
                ->where('is_positive', $is_positive)
                ->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user_id,
                'foreign_type' => 'video',
                'foreign_id' => $video_id,
                'is_positive' => $is_positive,
            ]);
            $liked = true;
        }

        $html = '';
        $html .= view('video.likeBtn', compact('user_id', 'video_id', 'liked'));

        return response()->json([
            'likeBtn' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function save(Request $request)
    {
        $user_id = request('save-user-id');
        $video_id = request('save-video-id');
        $saved = request('save-status');

        if ($saved) {
            Save::where('user_id', $user_id)->where('video_id', $video_id)->delete();
            $saved = false;
        } else {
            Save::create(['user_id' => $user_id, 'video_id' => $video_id]);
            $saved = true;
        }

        $html = '';
        $html .= view('video.saveBtn', compact('user_id', 'video_id', 'saved'));

        return response()->json([
            'saveBtn' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function loadComment(Request $request)
    {
        $video_id = $request->id;
        $comments = Comment::with('user:id,name,avatar_temp', 'likes')
                    ->where('foreign_id', $video_id)
                    ->withCount('replies')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->sortBy(function($comment)
        {
            return $comment->likes->where('is_positive', false)->count() - $comment->likes->where('is_positive', true)->count();
        });

        $html = '';
        $html .= view('video.comment-section-wrapper', compact('video_id', 'comments'));

        return response()->json([
            'comments' => $html,
        ]);
    }

    public function createComment(Request $request)
    {
        $comment = Comment::create([
            'user_id' => request('comment-user-id'),
            'type' => request('comment-type'),
            'foreign_id' => request('comment-foreign-id'),
            'text' => request('comment-text'),
        ]);

        $html = '';
        $html .= view('video.singleVideoComment', compact('comment'));

        $comment_count = request('comment-count') + 1;

        return response()->json([
            'comment_id' => $comment->id,
            'comment_count' => $comment_count,
            'single_video_comment' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function commentLike(Request $request)
    {
        $commentLikeUserId = request('comment-like-user-id');
        $foreign_type = request('foreign_type');
        $foreign_id = request('foreign_id');
        $is_positive = request('is_positive');
        $likedComment = request('like-comment-status');
        $commentLikesCount = request('comment-likes-count');
        $commentLikesSum = request('comment-likes-sum');
        $unlikedComment = request('unlike-comment-status');

        if ($is_positive) {
            if ($likedComment) {
                Like::where('user_id', $commentLikeUserId)
                    ->where('foreign_type', $foreign_type)
                    ->where('foreign_id', $foreign_id)
                    ->where('is_positive', $is_positive)
                    ->delete();
                $likedComment = false;
                $commentLikesCount--;
                $commentLikesSum--;
            } else {
                Like::create([
                    'user_id' => $commentLikeUserId,
                    'foreign_type' => $foreign_type,
                    'foreign_id' => $foreign_id,
                    'is_positive' => $is_positive,
                ]);
                $likedComment = true;
                $commentLikesCount++;
                $commentLikesSum++;
            }

        } else {
            if ($unlikedComment) {
                Like::where('user_id', $commentLikeUserId)
                    ->where('foreign_type', $foreign_type)
                    ->where('foreign_id', $foreign_id)
                    ->where('is_positive', $is_positive)
                    ->delete();
                $unlikedComment = false;
                $commentLikesCount++;
                $commentLikesSum++;
            } else {
                Like::create([
                    'user_id' => $commentLikeUserId,
                    'foreign_type' => $foreign_type,
                    'foreign_id' => $foreign_id,
                    'is_positive' => $is_positive,
                ]);
                $unlikedComment = true;
                $commentLikesCount--;
                $commentLikesSum--;
            }
        }

        $html = '';
        $html .= view('video.comment-like-btn', compact('commentLikeUserId', 'likedComment', 'commentLikesCount', 'commentLikesSum', 'unlikedComment'));

        return response()->json([
            'comment_like_btn' => $html,
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

    public function loadReplies(Request $request)
    {
        $comment_id = $request->id;
        $replies = Reply::with('user:id,name,avatar_temp', 'likes')
                        ->where('comment_id', $comment_id)
                        ->orderBy('created_at', 'asc')
                        ->get();

        $html = '';
        $html .= view('reply.index', compact('comment_id', 'replies'));

        return response()->json([
            'comment_id' => $comment_id,
            'replies' => $html,
        ]);
    }

    public function addTags(Request $request)
    {
        $request->validate([
            'h-captcha-response' => 'required',
        ], [
            'h-captcha-response.required' => '請先勾選「我是人類」',       
        ]);

        $video = Video::find($request->video_id);
        if ($tags = $request->tags) {
            $tags_array = $video->tags_array;
            foreach ($tags as $tag) {
                if (array_key_exists($tag, $video->tags_array)) {
                    $tags_array[$tag] = $tags_array[$tag] + 1;
                } elseif (in_array($tag, Video::$all_tag)) {
                    $tags_array[$tag] = 1;
                }
            }
            $video->tags_array = $tags_array;
            $video->save();
        }
        return Redirect::route('video.watch', ['v' => $video->id]);
    }

    public function removeTags(Request $request)
    {
        $request->validate([
            'h-captcha-response' => 'required',
        ], [
            'h-captcha-response.required' => '請先勾選「我是人類」',       
        ]);

        $video = Video::find($request->video_id);
        if ($tags = $request->tags) {
            $tags_array = $video->tags_array;
            foreach ($tags_array as $key => $value) {
                if (!in_array($key, $tags) && in_array($key, Video::$all_tag)) {
                    $tags_array[$key] = $tags_array[$key] - 1;
                    if ($tags_array[$key] <= 0) {   
                        unset($tags_array[$key]);
                    }
                }
            }
            $video->tags_array = $tags_array;
            $video->save();
        }
        return Redirect::route('video.watch', ['v' => $video->id]);
    }
}
