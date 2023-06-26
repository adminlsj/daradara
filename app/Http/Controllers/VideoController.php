<?php

namespace App\Http\Controllers;

use App\Video;
use App\Watch;
use App\User;
use App\Comment;
use App\Reply;
use App\Like;
use App\Save;
use App\Playlist;
use App\Playitem;
use App\Bot;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use SteelyWing\Chinese\Chinese;
use App\Helper;
use Redirect;
use Validator;
use Mail;
use App\Mail\UserAddedTags;
use Illuminate\Support\Arr;

class VideoController extends Controller
{
    public function watch(Request $request)
    {
        $vid = $request->v;

        if (is_numeric($vid) && $video = Video::with('watch:id,title')->select('id', 'user_id', 'playlist_id', 'comic_id', 'title', 'translations', 'caption', 'cover', 'genre', 'tags_array', 'sd', 'qualities', 'downloads', 'sd_sc', 'qualities_sc', 'downloads_sc', 'outsource', 'has_subtitles', 'current_views', 'week_views', 'month_views', 'views', 'imgur', 'foreign_sd', 'duration', 'has_torrent', 'artist', 'created_at', 'uploaded_at')->withCount('likes')->find($vid)) {

            if (in_array($video->genre, ['日本AV', '素人業餘', '高清無碼', 'AI解碼', '國產AV', '國產素人'])) {
                return Redirect::to(route('jav.watch')."?v={$vid}");
            }

            $current = $video;
            $doujin = false;
            $user = auth()->user();
            $artist = User::select('id', 'name', 'avatar_temp')->withCount('videos')->find($video->user_id);
            $is_mobile = Helper::checkIsMobile();

            $video->current_views++;
            $video->week_views++;
            $video->month_views++;
            $video->views++;
            $video->save();

            $videos = Video::where('playlist_id', $video->playlist_id)->orderBy('created_at', 'desc')->select('id', 'user_id', 'cover', 'imgur', 'title', 'sd', 'views', 'duration', 'created_at')->get();

            $tags = $tags_random = array_keys($video->tags_array);
            shuffle($tags_random);
            $tags_slice = array_slice($tags_random, 0, 5);
            $genre = $video->genre;
            if ($genre == 'Motion Anime' || $genre == '3D動畫' || $genre == '同人作品' || $genre == 'Cosplay') {
                $doujin = true;
            }
            $related = Video::where('genre', $genre)->where(function($query) use ($tags_slice) {
                foreach ($tags_slice as $tag) {
                    $query->orWhere('tags_array', 'like', '%"'.$tag.'"%');
                }
            });

            if ($doujin) {
                $related = $related->with('user:id,name,avatar_temp')->where('id', '!=', $current->id)->inRandomOrder()->select('id', 'user_id', 'cover', 'imgur', 'title', 'sd', 'qualities', 'views', 'duration', 'created_at')->limit(60)->get();

            } else {
                $related = $related->where('uncover', false)->where('playlist_id', '!=', $current->playlist_id)->inRandomOrder()->select('id', 'user_id', 'cover', 'imgur', 'title', 'sd', 'qualities', 'views', 'created_at')->limit(60)->get();
            }

            $country_code = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : 'N/A';

            $comments_count = Comment::where('foreign_id', $video->id)->where('type', 'video')->count();

            if (Auth::check()) {
                $saved = Save::where('user_id', $user->id)->where('video_id', $video->id)->exists();
                $listed = Playitem::where('user_id', $user->id)->where('video_id', $video->id)->get();
                $playlists = Playlist::where('user_id', $user->id)->where('reference_id', null)->select('id', 'user_id', 'title', 'created_at')->orderBy('created_at', 'desc')->get();
                $liked = Like::where('user_id', $user->id)->where('foreign_type', 'video')->where('foreign_id', $video->id)->exists();
            } else {
                $saved = false;
                $listed = '[]';
                $playlists = '[]';
                $liked = false;
            }

            $lang = Helper::getPreferredLanguage();
            if ($current->sd_sc && $lang == 'zh-CHS') {
                $sd = $video->sd_sc;
                $qualities = $video->qualities_sc;
                $downloads = $video->downloads_sc;
            } else {
                $sd = $video->sd;
                $qualities = $video->qualities;
                $downloads = $video->downloads;
            }
            if (strpos($sd, 'vbalancer') !== false) {
                $balancer = Helper::get_string_between($sd, 'vbalancer-', '.hembed');
                $server = Arr::random(Video::$vod_servers[$balancer - 1]);
                $sd = $this->getServerSd($balancer, $server, $sd);
                $qualities = $this->getServerQual($balancer, $server, $qualities);
            }
            $qual = $qualities != null ? Helper::getPreferredQuality(array_keys($qualities)) : 720;

        } else {
            abort(403);
        }

        return view('video.watch-2022-12-19', compact('video', 'artist', 'videos', 'current', 'tags', 'country_code', 'comments_count', 'related', 'doujin', 'is_mobile', 'saved', 'listed', 'playlists', 'liked', 'lang', 'sd', 'qual', 'qualities', 'downloads'));
    }

    public function download(Request $request)
    {
        $is_mobile = Helper::checkIsMobile();

        $vid = $request->v;
        if (is_numeric($vid) && $video = Video::select('id', 'user_id', 'playlist_id', 'title', 'translations', 'caption', 'cover', 'tags', 'sd', 'qualities', 'downloads', 'sd_sc', 'qualities_sc', 'downloads_sc', 'outsource', 'current_views', 'views', 'imgur', 'foreign_sd', 'duration', 'has_torrent', 'artist', 'created_at', 'uploaded_at')->find($vid)) {

            $lang = Helper::getPreferredLanguage();
            if ($video->sd_sc && $lang == 'zh-CHS') {
                $sd = $video->sd_sc;
                $qualities = $video->qualities_sc;
                $downloads = $video->downloads_sc;
            } else {
                $sd = $video->sd;
                $qualities = $video->qualities;
                $downloads = $video->downloads;
            }

            if ($downloads != null) {
                $qualities = $downloads;
            }

            if ($qualities == null) {
                abort(403);
            }

            if (strpos($sd, 'vbalancer') !== false) {
                $balancer = Helper::get_string_between($sd, 'vbalancer-', '.hembed');
                $server = Arr::random(Video::$vod_servers[$balancer - 1]);
                $sd = $this->getServerSd($balancer, $server, $sd);
                $qualities = $this->getServerQual($balancer, $server, $qualities);
            }

            $torrent = '';
            if ($video->has_torrent) {
                $url = 'https://vtorrent.hembed.com/'.$video->id.'.torrent';
                $torrent = Helper::sign_bcdn_url($url, env('BUNNY_TOKEN'), 43200);
            }

        } else {
            abort(403);
        }

        return view('video.download', compact('video', 'sd', 'qualities', 'is_mobile', 'torrent'));
    }

    public function getServerSd($balancer, $server, $sd)
    {
        $sd = str_replace("vbalancer-{$balancer}.hembed.com", "vdownload-{$server}.hembed.com", $sd);
        $sd = Helper::sign_hembed_url($sd, env('HEMBED_TOKEN'), 43200);
        return $sd;
    }

    public function getServerQual($balancer, $server, $qualities)
    {
        foreach ($qualities as &$qual) {
            $qual = str_replace("vbalancer-{$balancer}.hembed.com", "vdownload-{$server}.hembed.com", $qual);
            $qual = Helper::sign_hembed_url($qual, env('HEMBED_TOKEN'), 43200);
        }
        return $qualities;
    }

    public function like(Request $request)
    {
        $user_id = request('like-user-id');
        $video_id = request('like-foreign-id');
        $is_positive = request('like-is-positive');
        $liked = request('like-status');
        $likes_count = request('likes-count');

        if ($liked) {
            Like::where('user_id', $user_id)
                ->where('foreign_type', 'video')
                ->where('foreign_id', $video_id)
                ->where('is_positive', $is_positive)
                ->delete();
            $liked = false;
            $likes_count--;
        } else {
            Like::create([
                'user_id' => $user_id,
                'foreign_type' => 'video',
                'foreign_id' => $video_id,
                'is_positive' => $is_positive,
            ]);
            $liked = true;
            $likes_count++;
        }

        $html = '';
        $html .= view('video.likeBtn', compact('user_id', 'video_id', 'liked', 'likes_count'));

        return response()->json([
            'likeBtn' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function save(Request $request)
    {
        $input_id = request('input_id');
        $user_id = Auth::user()->id;
        $video_id = request('video_id');
        $is_checked = request('is_checked');

        if ($input_id == 'save') {

            if ($is_checked == 'true') {
                Save::create(['user_id' => $user_id, 'video_id' => $video_id]);

            } elseif ($is_checked == 'false') {
                Save::where('user_id', $user_id)->where('video_id', $video_id)->delete();
            }

        } else {

            if ($is_checked == 'true') {
                Playitem::create(['user_id' => $user_id, 'playlist_id' => $input_id, 'video_id' => $video_id]);

            } elseif ($is_checked == 'false') {
                Playitem::where('user_id', $user_id)->where('playlist_id', $input_id)->where('video_id', $video_id)->delete();
            }

        }

        $save_icon = $is_checked == 'true' ? 'playlist_add_check' : 'playlist_add';
        $save_text = $is_checked == 'true' ? '已儲存' : '儲存';
        $save_btn = '';
        $save_btn .= view('video.saveBtn-new', compact('save_icon', 'save_text'));

        return response()->json([
            'saveBtn' => $save_btn,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function loadComment(Request $request)
    {
        $foreign_id = $request->id;
        $type = $request->type;
        $comments = Comment::with('user:id,name,avatar_temp', 'likes')
                    ->where('foreign_id', $foreign_id)
                    ->where('type', $type)
                    ->withCount('replies')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->sortBy(function($comment)
        {
            return $comment->likes->where('is_positive', false)->count() - $comment->likes->where('is_positive', true)->count();
        });

        $html = '';
        $html .= view('video.comment-section-wrapper', compact('foreign_id', 'type', 'comments'));

        return response()->json([
            'comments' => $html,
        ]);
    }

    public function createComment(Request $request)
    {
        $request->validate([
            'comment-user-id' => 'required',
            'comment-type' => 'required|string|max:255',
            'comment-foreign-id' => 'required',
            'comment-text' => 'required|string|max:255',
        ]);

        $ip_address = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : 'N/A';
        $comment = Comment::create([
            'user_id' => request('comment-user-id'),
            'type' => request('comment-type'),
            'foreign_id' => request('comment-foreign-id'),
            'text' => request('comment-text'),
            'ip_address' => $ip_address,
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
        $request->validate([
            'reply-comment-id' => 'required',
            'reply-comment-text' => 'required|string|max:255',
        ]);

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

        $user = Auth::user();
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

            $ip_address = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : 'N/A';
            $country_code = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : 'N/A';
            Mail::to('vicky.avionteam@gmail.com')->send(new UserAddedTags($user->email, 'Added tags: '.implode(", ",$tags), $video->id, $video->title, $video->sd, $ip_address, $country_code, $tags));
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
