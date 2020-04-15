<?php

namespace App\Http\Controllers;

use App\User;
use App\Video;
use App\Watch;
use App\Subscribe;
use App\Avatar;
use Illuminate\Http\Request;
use Hash;
use Storage;
use File;
use Image;
use Mail;
use Auth;
use App\Mail\UserStartUpload;
use Redirect;
use Carbon\Carbon;

class SubscribeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('create', 'destroy');
    }

    public function index(Request $request)
    {
        if (auth()->check()) {
            $subscribes = auth()->user()->subscribes();
            if ($subscribes->isEmpty()) {
                $trendings = Video::whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(2))->inRandomOrder()->limit(16)->get();
                $newest = Video::orderBy('uploaded_at', 'desc')->limit(16)->get();
                $load_more = Video::whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(2))->orderBy('views', 'desc')->paginate(12);

                $html = '';
                foreach ($load_more as $video) {
                    $html .= view('video.load-more', compact('video'));
                }
                if ($request->ajax()) {
                    return $html;
                }

                $is_mobile = $this->checkMobile();

                return view('subscribe.empty', compact('trendings', 'newest', 'load_more', 'is_mobile'));
            }

            $videos = [];
            $g = $request->get('g');
            if ($g != 'newest' && $g != 'saved') {
                $g = 'newest';
            }
            if ($g == 'newest') {
                $first = true;
                foreach ($subscribes as $subscribe) {
                    if ($first) {
                        if ($subscribe->type == 'watch') {
                            $watch = Watch::where('title', $subscribe->tag)->first();
                            $videos = Video::where('playlist_id', $watch->id);
                        } else {
                            $videos = Video::where('tags', 'LIKE', '%'.$subscribe->tag.'%');
                        }
                        $first = false;
                    } else {
                        if ($subscribe->type == 'watch') {
                            $watch = Watch::where('title', $subscribe->tag)->first();
                            $videos = $videos->orWhere('playlist_id', $watch->id);
                        } else {
                            $videos = $videos->orWhere('tags', 'LIKE', '%'.$subscribe->tag.'%');
                        }
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

            return view('subscribe.index', compact('subscribes', 'videos'));

        } else {
            return view('auth.login');
        }
    }

    public function store(Request $request)
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

    public function destroy(Request $request)
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

    public function tag(Request $request) {
        $tag = request('query');
        $videos = Video::where('tags', 'like', '%'.$tag.'%')->orderBy('uploaded_at', 'desc')->paginate(10);

        $html = $this->searchLoadHTML($videos);
        if ($request->ajax()) {
            return $html;
        }

        $is_subscribed = $this->is_subscribed($tag);

        return view('video.subscribeTag', compact('tag', 'videos', 'is_subscribed'));
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
}
