<?php

namespace App\Http\Controllers;

use App\Video;
use App\Watch;
use App\User;
use App\Subscribe;
use App\Like;
use App\Save;
use App\Comment;
use App\Method;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;
use Carbon\Carbon;
use Response;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('edit', 'update', 'destroy');
    }

    public function explore(Request $request){
        if ($request->ajax()) {
            switch ($request->path()) {
                case 'rank':
                    $videos = Video::whereDate('uploaded_at', '>=', Carbon::now()->subMonth())->orderBy('views', 'desc');
                    break;

                case 'newest':
                    $videos = Video::whereDate('uploaded_at', '>=', Carbon::now()->subMonth())->orderBy('uploaded_at', 'desc');
                    break;
                
                default:
                    $videos = Video::whereDate('uploaded_at', '>=', Carbon::now()->subMonth())->orderBy('views', 'desc');
                    break;
            }

            $videos = $videos->paginate(24);

            $html = '';
            foreach ($videos as $video) {
                $html .= view('video.singleLoadMoreSliderVideos', compact('video'));
            }

            return $html;
        }

        return view('video.rankIndex');
    }

    public function playlist(Request $request){
        if ($request->has('list') && $request->list != 'null') {

            $watch = Watch::find($request->list);
            $videos = $watch->videos();

            $first = $watch->videos()->first();
            $is_subscribed = $this->is_subscribed($watch->title);
            $is_mobile = Method::checkMobile();

            return view('video.intro', compact('watch', 'videos', 'first', 'is_subscribed', 'is_mobile'));
        }
    }

    public function intro(String $genre, String $title, Request $request){
        $title = str_replace("_", " / ", $title);
        $title = str_replace("-", " ", $title);
        if ($title == '雙層公寓：東京2019 2020') {
            $title = '雙層公寓：東京2019-2020';
        }
        if ($title == 'A Studio') {
            $title = 'A-Studio';
        }
        $watch = Watch::where('title', $title)->first();
        $videos = $watch->videos();

        $first = $watch->videos()->first();

        $is_subscribed = $this->is_subscribed($watch->title);

        $is_mobile = Method::checkMobile();

        return view('video.intro', compact('watch', 'videos', 'first', 'is_subscribed', 'is_mobile'));
    }

    public function watch(Request $request){
        $vid = $request->v;

        if (is_numeric($vid) && $video = Video::find($request->v)) {
            $video->views++;
            $video->save();

            $current = $video;
            $is_mobile = Method::checkMobile();

            $query = Video::where('playlist_id', $video->playlist_id)->orderBy('created_at', 'asc')->pluck('id')->toArray();
            $now = array_search($video->id, $query);
            $prev = $now == 0 ? false : $query[$now - 1];
            $next = $now == (count($query) - 1) ? false : $query[$now + 1];

            if ($video->playlist_id != null) {
                $watch = Watch::find($video->playlist_id);
                $is_subscribed = $this->is_subscribed($watch->title);
                $is_program = true;
            } else {
                $watch = null;
                $is_subscribed = false;
                $is_program = false;
            }

            return view('video.showWatch', compact('video', 'prev', 'next', 'watch', 'current', 'is_program', 'is_subscribed', 'is_mobile'));

        } else {
            return view('errors.404');
        }
    }

    public function videoLoadHTML($videos)
    {
        $html = '';
        foreach ($videos as $video) {
            $html .= view('video.singleVideoPost', compact('video'));
        }
        return $html;
    }

    public function subscribeIndex(Request $request)
    {
        if (auth()->check()) {
            $subscribes = auth()->user()->subscribes();
            if ($subscribes->isEmpty()) {
                $trendings = Video::whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(2))->inRandomOrder()->limit(16)->get();
                $newest = Video::orderBy('uploaded_at', 'desc')->limit(16)->get();
                $load_more = Video::whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(2))->orderBy('views', 'desc')->paginate(12);

                $html = '';
                foreach ($load_more as $video) {
                    $html .= view('video.singleLoadMoreSliderVideos', compact('video'));
                }
                if ($request->ajax()) {
                    return $html;
                }

                $is_mobile = Method::checkMobile();

                return view('video.subscribeIndexEmpty', compact('trendings', 'newest', 'load_more', 'is_mobile'));
            }

            $videos = Video::query();
            $g = $request->get('g');
            if ($g != 'newest' && $g != 'saved') {
                $g = 'newest';
            }
            if ($g == 'newest') {
                foreach ($subscribes as $subscribe) {
                    if ($subscribe->type == 'watch') {
                        $watch = Watch::where('title', $subscribe->tag)->first();
                        $videos = $videos->orWhere('playlist_id', $watch->id);
                    } else {
                        $videos = $videos->orWhere('tags', 'LIKE', '%'.$subscribe->tag.'%');
                    }
                }

            } elseif ($g == 'saved') {
                $saved = Save::where('user_id', auth()->user()->id)->get();
                $first = true;
                foreach ($saved as $save) {
                    if ($first) {
                        $videos = Video::where('id', $save->foreign_id);
                        $first = false;
                    } else {
                        $videos = $videos->orWhere('id', $save->foreign_id);
                    }
                }
            }
            
            if ($videos != []) {
                $videos = $videos->orderBy('uploaded_at', 'desc')->paginate(10);
            }

            $html = $this->subscribeLoadHTML($videos);
            if ($request->ajax()) {
                return $html;
            }

            $user = auth()->user();
            $user->alert = str_replace('subscribe', '', $user->alert);
            $user->save();

            return view('video.subscribeIndex', compact('subscribes', 'videos'));

        } else {
            return view('auth.login');
        }
    }

    public function subscribe(Request $request)
    {
        $user = User::find(request('subscribe-user-id'));
        $source = request('subscribe-source');
        $type = request('subscribe-type');
        $tag = request('subscribe-tag');

        if (Subscribe::where('user_id', Auth::user()->id)->where('tag', $tag)->first() == null) {
            $subscribe = Subscribe::create([
                'user_id' => $user->id,
                'type' => $type,
                'tag' => $tag,
            ]);
        }

        $html = '';
        switch ($source) {
            case 'video':
                $html .= view('video.unsubscribeBtn', compact('tag'));
                break;

            case 'intro':
                $html .= view('video.intro-unsubscribe-btn', compact('tag'));
                break;

            case 'show':
                $html .= view('video.watch-unsubscribe-btn', compact('tag'));
                break;

            case 'tag':
                $html .= view('video.tag-unsubscribe-btn', compact('tag'));
                break;
            
            default:
                $html .= view('video.unsubscribeBtn', compact('tag'));
                break;
        }

        return response()->json([
            'unsubscribe_btn' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function unsubscribe(Request $request)
    {
        $user = User::find(request('subscribe-user-id'));
        $source = request('subscribe-source');
        $type = request('subscribe-type');
        $tag = request('subscribe-tag');

        if (Auth::user()->id == request('subscribe-user-id')) {
            $subscribe = Subscribe::where('user_id', $user->id)->where('tag', $tag);
            $subscribe->delete();
        }

        $html = '';
        switch ($source) {
            case 'video':
                $html .= view('video.subscribeBtn', compact('tag'));
                break;

            case 'intro':
                $html .= view('video.intro-subscribe-btn', compact('tag'));
                break;

            case 'show':
                $html .= view('video.watch-subscribe-btn', compact('tag'));
                break;

            case 'tag':
                $html .= view('video.tag-subscribe-btn', compact('tag'));
                break;
            
            default:
                $html .= view('video.subscribeBtn', compact('tag'));
                break;
        }

        return response()->json([
            'subscribe_btn' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function subscribeTag(Request $request) {
        $tag = request('query');
        $videos = Video::where('tags', 'like', '%'.$tag.'%')->orderBy('uploaded_at', 'desc')->paginate(10);

        $html = $this->searchLoadHTML($videos);
        if ($request->ajax()) {
            return $html;
        }

        $is_subscribed = $this->is_subscribed($tag);

        return view('video.subscribeTag', compact('tag', 'videos', 'is_subscribed'));
    }

    public function like(Request $request)
    {
        $user_id = request('like-user-id');
        $type = request('like-type');
        $foreign_id = request('like-foreign-id');
        $is_positive = request('like-is-positive');

        $like = Like::where('user_id', $user_id)->where('type', $type)->where('foreign_id', $foreign_id)->first();
        if ($like != null) {
            $like->delete();
        }

        $like = Like::create([
            'user_id' => $user_id,
            'type' => $type,
            'foreign_id' => $foreign_id,
            'is_positive' => $is_positive,
        ]);

        $video = Video::find($foreign_id);
        $html = '';
        $html .= view('video.unlikeBtn', compact('video'));

        return response()->json([
            'unlikeBtn' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function unlike(Request $request)
    {
        $user_id = request('like-user-id');
        $type = request('like-type');
        $foreign_id = request('like-foreign-id');
        $is_positive = request('like-is-positive');

        $like = Like::where('user_id', $user_id)->where('type', $type)->where('foreign_id', $foreign_id)->first();
        if ($like != null) {
            $like->delete();
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
        $foreign_id = request('save-foreign-id');

        if (Save::where('user_id', $user_id)->where('foreign_id', $foreign_id)->first() == null) {
            $save = Save::create([
                'user_id' => $user_id,
                'foreign_id' => $foreign_id,
            ]);
        }

        $video = Video::find($foreign_id);
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
        $foreign_id = request('save-foreign-id');

        $save = Save::where('user_id', $user_id)->where('foreign_id', $foreign_id)->first();
        if ($save != null) {
            $save->delete();
        }

        $video = Video::find($foreign_id);
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

        $html = '';
        $html .= view('video.singleVideoComment', compact('comment'));

        if (request('comment-type') == 'video') {
            $comment_count = $comment->video()->comments()->count();
        }
        return response()->json([
            'comment_count' => $comment_count,
            'single_video_comment' => $html,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function searchLoadHTML($videos)
    {
        $html = '';
        $is_program = false;
        foreach ($videos as $video) {
            $html .= view('video.singleSearchVideo', compact('video', 'is_program'));
        }
        return $html;
    }

    public function rankLoadHTML($videos)
    {
        $html = '';
        foreach ($videos as $video) {
            $html .= view('video.rankVideoPost', compact('video'));
        }
        return $html;
    }

    public function subscribeLoadHTML($videos)
    {
        $html = '';
        $is_program = false;
        foreach ($videos as $video) {
            $html .= view('video.singleSubscribeVideo', compact('video', 'is_program'));
        }
        return $html;
    }

    public function loadPlaylist(Request $request)
    {
        $video = Video::find($request->v);
        $current = $video;

        if ($request->list != '') {
            $videos = Video::where('playlist_id', $request->list)->orderBy('created_at', 'desc')->get();
            $videosSelect = Video::where('playlist_id', '!=', $video->playlist_id)->inRandomOrder()->select('id', 'tags')->get()->toArray();
        } else {
            $videos = null;
            $videosSelect = Video::where('id', '!=', $video->id)->inRandomOrder()->select('id', 'tags')->get()->toArray();
        }

        $rankings = [];
        foreach ($videosSelect as $videoSelect) {
            $score = 0;
            foreach ($video->tags() as $tag) {
                if (strpos($videoSelect['tags'], $tag) !== false) {
                    $score++;
                }
            }
            array_push($rankings, ['score' => $score, 'id' => $videoSelect['id']]);
        }
        usort($rankings, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        $related = [];
        for ($i = 0; $i < 30; $i++) {
            array_push($related, Video::find($rankings[$i]['id']));
        }

        $html = view('video.video-playlist-wrapper', compact('current', 'videos', 'related'));
        if ($request->ajax()) {
            return $html;
        }
    }

    public function searchGoogle(Request $request)
    {
        return view('video.searchGoogle');
    }

    public function has_prev(array $_array)
    {
      return prev($_array) !== false ?: key($_array) !== null;
    }

    public function has_next(array $_array)
    {
      return next($_array) !== false ?: key($_array) !== null;
    }

    public function is_subscribed(String $tag)
    {
        $is_subscribed = false;
        if (Auth::check() && Subscribe::where('user_id', Auth::user()->id)->where('tag', $tag)->first() != null) {
            $is_subscribed = true;
        }
        return $is_subscribed;
    }
}
