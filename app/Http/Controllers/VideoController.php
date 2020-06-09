<?php

namespace App\Http\Controllers;

use App\Video;
use App\Watch;
use App\User;
use App\Subscribe;
use App\Like;
use App\Save;
use App\Blog;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
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
        return view('video.rankIndex');
    }

    public function recommend(Request $request){
        if (Auth::check() && auth()->user()->subscribes()->first()) {
            return view('video.recommend');
        } else {
            return redirect('/');
        }
    }

    public function playlist(Request $request){
        if ($request->has('list') && $request->list != 'null') {

            $watch = Watch::find($request->list);
            $user = $watch->user();
            $videos = Video::where('playlist_id', $watch->id)->orderBy('created_at', 'desc')->select('id', 'user_id', 'imgur', 'title')->get();
            $count = $videos->count();

            $first = $videos->first();
            $is_subscribed = $this->is_subscribed($watch->title);
            $is_mobile = $this->checkMobile();

            return view('video.intro', compact('watch', 'user', 'videos', 'count', 'first', 'is_subscribed', 'is_mobile'));
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

        $is_mobile = $this->checkMobile();

        return view('video.intro', compact('watch', 'videos', 'first', 'is_subscribed', 'is_mobile'));
    }

    public function watch(Request $request){
        $vid = $request->v;

        if (is_numeric($vid) && $video = Video::find($request->v)) {

            // QQ video auto transform START
            /*if (substr($video->sd, 0, 5) === "1098_") {
                $video->sd = Video::getSourceQQ("https://quan.qq.com/video/".$video->sd);
                $video->save();
            }
            if (substr($video->sd, 0, 5) === "1006_" || substr($video->sd, 0, 5) === "1097_") {
                $video->sd = Video::getSourceQZ($video->sd);
                $video->save();
            }*/
            // QQ video auto transform END

            $video->views++;
            $video->save();

            $current = $video;
            $is_mobile = $this->checkMobile();

            if ($video->playlist_id != null) {
                $watch = Watch::withVideos()->where('id', $video->playlist_id)->first();
                $is_subscribed = $this->is_subscribed($watch->title);
                $is_program = true;
            } else {
                $watch = null;
                $is_subscribed = false;
                $is_program = false;
            }

            return view('video.showWatch', compact('video', 'watch', 'current', 'is_program', 'is_subscribed', 'is_mobile'));

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
        $user = auth()->user();
        if (auth()->check()) {
            $subscribes = $user->subscribes();

            if ($subscribes->isEmpty()) {
                $animeFirst = Video::tagsWithLimit(['正版動漫'], 1)->get();
                $animeVid = Video::where('id', '!=', $animeFirst[0]->id)->tagsWithLimit(['正版動漫', '動畫', '動漫講評', 'MAD·AMV'], 7)->get();
                $animeNews = Blog::tagsWithLimit(['動漫情報'])->get();
                $variety = Video::tagsWithLimit(['綜藝'])->get();
                $artist = Video::tagsWithLimit(['明星', '日劇'])->get();
                $meme = Video::tagsWithLimit(['迷因'])->get();
                $daily = Blog::tagsWithLimit(['生活'])->get();
                return view('video.subscribeIndexEmpty', compact('animeFirst', 'animeVid', 'animeNews', 'variety', 'artist', 'meme', 'daily'));
            }

            if ($request->ajax()) {
                $videos = Video::with('watch:id');
                switch ($request->get('g')) {
                    case 'saved':
                        $saved = Save::where('user_id', $user->id)->pluck('foreign_id');
                        $videos = $videos->whereIn('id', $saved);
                        break;
                    
                    default:
                        foreach ($subscribes as $subscribe) {
                            if ($subscribe->type == 'watch') {
                                $watch = Watch::where('title', $subscribe->tag)->first();
                                $videos->orWhere('playlist_id', $watch->id);
                            } else {
                                $videos->orWhere('tags', 'LIKE', '%'.$subscribe->tag.'%');
                            }
                        }
                        break;
                }
                
                if ($videos != []) {
                    $videos = $videos->orderBy('uploaded_at', 'desc')->paginate(10);
                }

                return $this->subscribeLoadHTML($videos);
            }

            $user->alert = str_replace('subscribe', '', $user->alert);
            $user->save();

            return view('video.subscribeIndex', compact('subscribes'));

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
            $subscribe = Subscribe::where('user_id', $user->id)->where('tag', $tag)->first();
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

    public function loadChannelVideos(Request $request) {
        $tag = $request->tag;
        $genre = $request->genre;

        if ($genre == 'aninews' || $genre == 'daily') {
            if (strpos($tag, '全部') !== false) {
                $tags = Blog::$content[$genre];
                $videos = Blog::tagsWithPaginate($tags)->orderBy('created_at', 'desc')->paginate(24);

            } else {
                $videos = Blog::tagsWithPaginate([$tag])->orderBy('created_at', 'desc')->paginate(24);
            }

        } else {
            if (strpos($tag, '全部') !== false) {
                $tags = Video::$content[$genre];
                $videos = Video::tagsWithPaginate($tags);
                if ($genre != 'meme') {
                    $videos = $videos->whereDate('uploaded_at', '>=', Carbon::now()->subMonths(3));
                }

            } else {
                if ($tag == 'anime1') {
                    $videos = Video::with('user:id,name')->where('user_id', 746)->select('id', 'user_id', 'imgur', 'title');
                } elseif ($tag == 'Gimy劇迷') {
                    $videos = Video::with('user:id,name')->where('user_id', 750)->select('id', 'user_id', 'imgur', 'title');
                } else {
                    $videos = Video::tagsWithPaginate([$tag]);
                }                    
            }
            $videos = $videos->orderBy('uploaded_at', 'desc')->paginate(24);
        }

        return $this->singleLoadMoreSliderVideosHTML($videos);
    }

    public function loadRankVideos(Request $request) {
        $tags = strpos($request->tag, '全部') !== false ? ['正版動漫', '動畫', '動漫講評', 'MAD·AMV', '綜藝', '日劇', '迷因翻譯'] : Video::$content[Video::$genres[$request->tag]];

        $week = Video::tagsWithPaginate($tags)->whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(1))->orderBy('views', 'desc')->limit(24)->get();
        $week_id = $week->pluck('id');

        $quarter = Video::whereNotIn('id', $week_id)->tagsWithPaginate($tags)->whereDate('uploaded_at', '>=', Carbon::now()->subMonths(3))->orderBy('views', 'desc')->limit(24)->get();
        $quarter_id = $quarter->pluck('id');

        $semi = Video::whereNotIn('id', $week_id)->whereNotIn('id', $quarter_id)->tagsWithPaginate($tags)->whereDate('uploaded_at', '>=', Carbon::now()->subMonths(6))->orderBy('views', 'desc')->limit(24)->get();
        $semi_id = $semi->pluck('id');

        $year = Video::whereNotIn('id', $week_id)->whereNotIn('id', $quarter_id)->whereNotIn('id', $semi_id)->tagsWithPaginate($tags)->whereDate('uploaded_at', '>=', Carbon::now()->subMonths(12))->orderBy('views', 'desc')->limit(24)->get();
        $year_id = $year->pluck('id');

        $videos = Video::whereNotIn('id', $week_id)->whereNotIn('id', $quarter_id)->whereNotIn('id', $semi_id)->whereNotIn('id', $year_id)->tagsWithPaginate($tags)->whereDate('uploaded_at', '>=', Carbon::now()->subMonths(3))->orderBy('views', 'desc')->paginate(24);

        $html = '';
        if ($request->page == 1) {
            $html .= $this->singleLoadMoreSliderVideosHTML($week);
            $html .= $this->singleLoadMoreSliderVideosHTML($quarter);
            $html .= $this->singleLoadMoreSliderVideosHTML($semi);
            $html .= $this->singleLoadMoreSliderVideosHTML($year);
        }
        $html .= $this->singleLoadMoreSliderVideosHTML($videos);
        return $html;
    }

    public function loadNewestVideos(Request $request) {
        $tags = strpos($request->tag, '全部') !== false ? [] : Video::$content[Video::$genres[$request->tag]];
        $videos = Video::tagsWithPaginate($tags)->whereDate('uploaded_at', '>=', Carbon::now()->subMonths(3))->orderBy('uploaded_at', 'desc')->paginate(24);

        return $this->singleLoadMoreSliderVideosHTML($videos);
    }

    public function loadRecommendVideos(Request $request) {
        $tag = strpos($request->tag, '全部') !== false ? '' : $request->tag;
        $path = $request->path;
        $videos = Video::query();

        $tags = [];
        $user = auth()->user();
        $subscribes = Subscribe::where('user_id', $user->id)->orderBy('created_at', 'asc')->get();
        foreach ($subscribes as $subscribe) {
            if ($subscribe->type == 'watch' && $watch = $subscribe->watch()) {
                $videoTags = $watch->videos()->first()->tags;
                if (strpos($videoTags, '動漫') !== false && !in_array('動漫', $tags)) {
                    array_unshift($tags, '動漫');
                    if (!in_array('動漫講評', $tags)) {
                        array_push($tags, '動漫講評');
                    }
                    if (!in_array('MAD·AMV', $tags)) {
                        array_push($tags, 'MAD·AMV');
                    }
                    if (!in_array('動畫', $tags)) {
                        array_push($tags, '動畫');
                    }
                }
                if (strpos($videoTags, '日劇') !== false && !in_array('日劇', $tags)) {
                    array_unshift($tags, '日劇');
                    if (!in_array('番宣', $tags)) {
                        array_push($tags, '番宣');
                    }
                    if (!in_array('日本人氣YouTuber', $tags)) {
                        array_push($tags, '日本人氣YouTuber');
                    }
                    if (!in_array('日劇講評', $tags)) {
                        array_push($tags, '日劇講評');
                    }
                }
                if (strpos($videoTags, '綜藝') !== false && !in_array('綜藝', $tags)) {
                    array_unshift($tags, '綜藝');
                    if (!in_array('日本人氣YouTuber', $tags)) {
                        array_push($tags, '日本人氣YouTuber');
                    }
                    if (!in_array('日本創意廣告', $tags)) {
                        array_push($tags, '日本創意廣告');
                    }
                }
            } elseif ($subscribe->type == 'video') {
                if (!in_array($subscribe->tag, $tags)) {
                    array_push($tags, $subscribe->tag);
                }
            }
        }

        $subscribes = [];
        $subscribes_id = [];
        if ($tag == '') {
            $subscriptions = auth()->user()->subscribes();
            if (!$subscriptions->isEmpty()) {
                $subscribes = Video::where(function($query) use ($subscriptions) {
                    foreach ($subscriptions as $subscribe) {
                        if ($subscribe->type == 'watch') {
                            $watch = Watch::where('title', $subscribe->tag)->first();
                            $query->orWhere('playlist_id', $watch->id);
                        } else {
                            $query->orWhere('tags', 'LIKE', '%'.$subscribe->tag.'%');
                        }
                    }
                })->whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(1))->where('tags', 'like', '%'.$tag.'%')->orderBy('uploaded_at', 'desc')->limit(12)->get();
                $subscribes_id = $subscribes->pluck('id');
            }

            $newest = Video::whereNotIn('id', $subscribes_id)->tagsWithPaginate($tags)->orderBy('uploaded_at', 'desc')->limit(24)->get();
            $newest_id = $newest->pluck('id');

            $trending = Video::whereNotIn('id', $subscribes_id)->whereNotIn('id', $newest_id)->tagsWithPaginate($tags)->whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(1))->orderBy('views', 'desc')->limit(24)->get();
            $trending_id = $trending->pluck('id');

            $views = Video::whereNotIn('id', $subscribes_id)->whereNotIn('id', $newest_id)->whereNotIn('id', $trending_id)->tagsWithPaginate($tags)->where('views', '>=', 5000)->inRandomOrder()->limit(12)->get();
            $views_id = $views->pluck('id');

            $videos = Video::whereNotIn('id', $subscribes_id)->whereNotIn('id', $newest_id)->whereNotIn('id', $trending_id)->whereNotIn('id', $views_id)->tagsWithPaginate($tags)->whereDate('uploaded_at', '>=', Carbon::now()->subMonths(3))->orderBy('uploaded_at', 'desc')->paginate(24);

        } elseif ($tag == '動漫新番') {
            $newest = Video::with('user:id,name')->whereNotIn('id', $subscribes_id)->where('user_id', 746)->orderBy('uploaded_at', 'desc')->limit(24)->select('id', 'user_id', 'imgur', 'title')->get();
            $newest_id = $newest->pluck('id');

            $trending = Video::with('user:id,name')->whereNotIn('id', $subscribes_id)->whereNotIn('id', $newest_id)->where('user_id', 746)->whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(1))->orderBy('views', 'desc')->limit(12)->select('id', 'user_id', 'imgur', 'title')->get();
            $trending_id = $trending->pluck('id');

            $views = Video::with('user:id,name')->whereNotIn('id', $subscribes_id)->whereNotIn('id', $newest_id)->whereNotIn('id', $trending_id)->where('user_id', 746)->where('views', '>=', 5000)->inRandomOrder()->limit(12)->select('id', 'user_id', 'imgur', 'title')->get();
            $views_id = $views->pluck('id');

            $videos = Video::with('user:id,name')->whereNotIn('id', $subscribes_id)->whereNotIn('id', $newest_id)->whereNotIn('id', $trending_id)->whereNotIn('id', $views_id)->where('user_id', 746)->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'imgur', 'title')->paginate(24);

        } else {
            $newest = Video::whereNotIn('id', $subscribes_id)->tagsWithPaginate([$tag])->orderBy('uploaded_at', 'desc')->limit(24)->get();
            $newest_id = $newest->pluck('id');

            $trending = Video::whereNotIn('id', $subscribes_id)->whereNotIn('id', $newest_id)->tagsWithPaginate([$tag])->whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(1))->orderBy('views', 'desc')->limit(12)->get();
            $trending_id = $trending->pluck('id');

            $views = Video::whereNotIn('id', $subscribes_id)->whereNotIn('id', $newest_id)->whereNotIn('id', $trending_id)->tagsWithPaginate([$tag])->where('views', '>=', 5000)->inRandomOrder()->limit(12)->get();
            $views_id = $views->pluck('id');

            $videos = Video::whereNotIn('id', $subscribes_id)->whereNotIn('id', $newest_id)->whereNotIn('id', $trending_id)->whereNotIn('id', $views_id)->tagsWithPaginate([$tag]);

            if ($tag != '原創動畫' && $tag != '同人動畫' && $tag != '動漫講評' && $tag != 'MAD·AMV') {
                $videos = $videos->whereDate('uploaded_at', '>=', Carbon::now()->subMonths(3));
            }

            $videos = $videos->orderBy('uploaded_at', 'desc')->paginate(24);
        }

        $html = '';
        if ($request->page == 1) {
            $html .= $this->singleLoadMoreSliderVideosHTML($subscribes);
            $html .= $this->singleLoadMoreSliderVideosHTML($newest);
            $html .= $this->singleLoadMoreSliderVideosHTML($trending);
            $html .= $this->singleLoadMoreSliderVideosHTML($views);
        }
        $html .= $this->singleLoadMoreSliderVideosHTML($videos);
        return $html;
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

    public function singleLoadMoreSliderVideosHTML($videos)
    {
        $html = '';
        foreach ($videos as $video) {
            $html .= view('video.new-singleLoadMoreVideos', compact('video'));
        }
        return $html;
    }

    public function singleLoadMoreSliderBlogsHTML($videos)
    {
        $html = '';
        foreach ($videos as $video) {
            $html .= view('blog.new-singleLoadMoreBlogs', compact('video'));
        }
        return $html;
    }

    public function checkMobile()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $is_mobile = false;
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { 
            $is_mobile = true;
        }
        return $is_mobile;
    }

    public function search(Request $request)
    {
        $query = str_replace(' ', '', request('query'));

        if ($query == '') {
            return redirect('/');
        }

        $queryArray = [];
        preg_match_all('/./u', $query, $queryArray);
        $queryArray = $queryArray[0];
        if (($key = array_search(' ', $queryArray)) !== false) {
            unset($queryArray[$key]);
        }

        $videosArray = [];
        $idsArray = [];

        // Exact Match Query [e.g. 2012.09.14]
        $exactQuery = Video::with('user:id,name')->where('title', 'ilike', '%'.trim(request('query')).'%')->orderBy('uploaded_at', 'desc')->distinct()->get();
        foreach ($exactQuery as $q) {
            if (!in_array($q->id, $idsArray)) {
                array_push($videosArray, $q);
                array_push($idsArray, $q->id);
            }
        }

        // Exact Order Match Query (search query in same order e.g. 2012 => 2>0>1>2) [e.g. 2012 09 14]
        $exactOrderQueryScope = '%'.implode('%', $queryArray).'%';
        $exactOrderQuery = Video::with('user:id,name')->where('title', 'ilike', $exactOrderQueryScope)->orderBy('uploaded_at', 'desc')->get();
        foreach ($exactOrderQuery as $q) {
            if (!in_array($q->id, $idsArray)) {
                array_push($videosArray, $q);
                array_push($idsArray, $q->id);
            }
        }

        if ($request->ajax()) {
            $videosArray = array_slice($videosArray, 24);
            $exactOrderTagQuery = Video::with('user:id,name')->where('tags', 'ilike', $exactOrderQueryScope)->orderBy('uploaded_at', 'desc')->get();
            foreach ($exactOrderTagQuery as $q) {
                if (!in_array($q->id, $idsArray)) {
                    array_push($videosArray, $q);
                    array_push($idsArray, $q->id);
                }
            }

            $page = Input::get('page', 1); // Get the ?page=1 from the url
            $perPage = 24; // Number of items per page
            $offset = ($page * $perPage) - $perPage;

            $videos = new LengthAwarePaginator(
                array_slice($videosArray, $offset, $perPage, true), // Only grab the items we need
                count($videosArray), // Total items
                $perPage, // Items per page
                $page, // Current page
                ['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
            );

            $html = $this->searchLoadHTML($videos);
            return $html;
        }

        $watches = Watch::withVideos()->where('title', 'ilike', $exactOrderQueryScope)->orderBy('created_at', 'desc')->get();
        $user = User::withCount('videos')->where('name', 'like', '%'.strtolower($query).'%')->first();
        $topResults = array_slice($videosArray, 0, 24);

        return view('video.search', compact('watches', 'query', 'topResults', 'user'));
    }

    public function loadPlaylist(Request $request)
    {
        $video = Video::find($request->v);
        $current = $video;

        $videosSelect = Video::where(function($query) use ($video) {
            foreach ($video->tags() as $tag) {
                $query->orWhere('tags', 'like', '%'.$tag.'%');
            }
        });

        if ($request->list != '') {
            $videos = Video::where('playlist_id', $request->list)->orderBy('created_at', 'desc')->select('id', 'imgur', 'title')->get();
            $videosSelect = $videosSelect->where('playlist_id', '!=', $video->playlist_id)->inRandomOrder()->select('id', 'tags')->get()->toArray();
        } else {
            $videos = null;
            $videosSelect = $videosSelect->where('id', '!=', $video->id)->inRandomOrder()->select('id', 'tags')->get()->toArray();
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

        $related = Video::with('user.avatar')->whereIn('id', Arr::pluck(array_slice($rankings, 0, 30), 'id'))->select('id', 'user_id', 'imgur', 'title')->get();

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

    public function getSource(Request $request)
    {
        $url = Input::get('url');
        if (strpos($url, 'https://www.instagram.com/p/') !== false) {
            return Video::getSourceIG($url);
        } elseif (strpos($url, 'player.bilibili.com') !== false) {
            return Video::getMobileBB($url);
        } else {
            return $url;
        }
    }

    public function createGetSource(Request $request)
    {
        $url = Input::get('url');
        if (strpos($url, 'https://www.instagram.com/p/') !== false) {
            return Video::getSourceIG($url);
        } elseif (strpos($url, 'www.bilibili.com') !== false) {
            $link = Video::getLinkBB($url, false);
            return Video::getSourceBB($link);
        } else {
            return $url;
        }
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
