<?php

namespace App\Http\Controllers;

use App\Video;
use App\Playlist;
use App\User;
use App\Subscribe;
use App\Like;
use App\Save;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Storage;
use File;
use Image;
use DB;
use Auth;
use App\Mail\Contact;
use App\Mail\ContactUser;
use Carbon\Carbon;
use Response;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('edit', 'update', 'destroy');
    }

    public function index(Request $request){
        switch ($request->path()) {
            case 'rank':
                $videos = Video::whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(2))->orderBy('views', 'desc');
                break;

            case 'newest':
                $videos = Video::whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(2))->orderBy('uploaded_at', 'desc');
                break;
            
            default:
                $videos = Video::whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(2))->orderBy('views', 'desc');
                break;
        }

        $videos = $videos->paginate(24);

        $html = '';
        foreach ($videos as $video) {
            $html .= view('video.load-more', compact('video'));
        }
        if ($request->ajax()) {
            return $html;
        }

        $is_mobile = $this->checkMobile();

        return view('video.index', compact('videos', 'is_mobile'));
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
        $playlist = Playlist::where('title', $title)->first();
        $videos = $playlist->videos();

        $first = $playlist->videos()->first();

        $is_subscribed = $this->is_subscribed($playlist->title);

        $is_mobile = $this->checkMobile();

        return view('playlist.show', compact('playlist', 'videos', 'first', 'is_subscribed', 'is_mobile'));
    }

    public function show(Request $request){
        $vid = $request->v;

        if (is_numeric($vid) && $video = Video::find($request->v)) {
            $video->views++;
            $video->save();

            $current = $video;
            $is_mobile = $this->checkMobile();

            $query = Video::where('playlist_id', $video->playlist_id)->orderBy('created_at', 'asc')->pluck('id')->toArray();
            $now = array_search($video->id, $query);
            while(key($query) !== null && key($query) !== $now) next($query);

            $prev = 0; $next = 0;
            if ($this->has_prev($query)) {
                $prev = prev($query);
                next($query);
            } else {
                $prev = false;
            }
            if ($this->has_next($query)) {
                $next = next($query);
            } else {
                $next = false;
            }

            if ($video->playlist_id != null) {
                $playlist = Playlist::find($video->playlist_id);
                $is_subscribed = $this->is_subscribed($playlist->title);
                $is_program = true;
            } else {
                $playlist = null;
                $is_subscribed = false;
                $is_program = false;
            }

            return view('video.show', compact('video', 'prev', 'next', 'playlist', 'current', 'is_program', 'is_subscribed', 'is_mobile'));

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
        $html .= view('video.unlike-btn', compact('video'));

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
        $html .= view('video.like-btn', compact('video'));

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
        $html .= view('video.unsave-btn', compact('video'));

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
        $html .= view('video.save-btn', compact('video'));

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
        $html .= view('video.comment-single', compact('comment'));

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

    public function checkMobile()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $is_mobile = false;
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { 
            $is_mobile = true;
        }
        return $is_mobile;
    }

    public function loadRelated(Request $request)
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
        if ($rankings != []) {
            for ($i = 0; $i < 30; $i++) {
                array_push($related, Video::find($rankings[$i]['id']));
            }
        }

        $html = view('video.related', compact('current', 'videos', 'related'));
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
