<?php

namespace App\Http\Controllers;

use App\Video;
use App\Watch;
use App\Subscribe;
use App\User;
use App\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Response;
use Mail;
use Auth;
use App\Mail\UserReport;
use App\Mail\CopyrightReport;
use App\Mail\UserUploadVideo;
use App\Mail\SubscribeNotify;
use Redirect;

class HomeController extends Controller
{
    public function index(Request $request){
        $subscribes = [];
        $subscribes_id = [];
        if (auth()->check()) {
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
                })->whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(1))->orderBy('uploaded_at', 'desc')->limit(12);
                $subscribes_id = $subscribes->pluck('id');
                $subscribes = $subscribes->get();
            }
        }

        $newest = Video::whereNotIn('id', $subscribes_id)->orderBy('uploaded_at', 'desc')->limit(12);
        $newest_id = $newest->pluck('id');
        $newest = $newest->get();

        if ($request->ajax()) {
            $html = '';
            $load_more = Video::whereNotIn('id', $subscribes_id)->whereNotIn('id', $newest_id)->whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(1))->orderBy('views', 'desc')->paginate(24);
            foreach ($load_more as $video) {
                $html .= view('video.singleLoadMoreSliderVideos', compact('video'));
            }
            return $html;
        }

        return view('video.home', compact('subscribes', 'newest'));
    }

    public function about(Request $request)
    {
        // User seeds
        switch ($request->seed) {
            case 'user':
                for ($i = 0; $i < 300; $i++) {
                    $user = User::create([
                        'name' => 'demo'.$i,
                        'email' => 'demo'.$i.'@gmail.com',
                        'password' => bcrypt('demo'.$i),
                    ]);
                    $user->delete();
                }
                break;

            case 'avatar':
                for ($i = 0; $i < 300; $i++) {
                    $avatar = Avatar::create([
                        'user_id' => 1,
                        'filename' =>'demo',
                        'mime' => 'jpg',
                    ]);
                    $avatar->delete();
                }
                break;

            case 'playlist':
                for ($i = 0; $i < 300; $i++) {
                    $playlist = Playlist::create([
                        'user_id' => 1,
                        'title' => 'demo',
                        'description' => 'demo',
                    ]);
                    $playlist->delete();
                }
                break;

            case 'video':
                for ($i = 0; $i < 300; $i++) {
                    $video = Video::create([
                        'user_id' => 1,
                        'playlist_id' => 1,
                        'title' => 'demo',
                        'description' => 'demo',
                        'link' => 'demo',
                        'imgur' => 'demo',
                        'tags' => 'demo',
                        'views' => 0,
                        'outsource' => true,
                        'created_at' => Carbon::now(),
                        'uploaded_at' => Carbon::now(),
                    ]);
                    $video->delete();
                }
                break;

            case 'comment':
                for ($i = 0; $i < 100; $i++) {
                    $comment = Comment::create([
                        'user_id' => 1,
                        'type' => 'demo',
                        'foreign_id' => 1,
                        'text' => 'demo',
                    ]);
                    $comment->delete();
                }
                break;

            case 'like':
                for ($i = 0; $i < 300; $i++) {
                    $like = Like::create([
                        'user_id' => 1,
                        'type' => 'demo',
                        'foreign_id' => 1,
                        'is_positive' => true,
                    ]);
                    $like->delete();
                }
                break;

            case 'save':
                for ($i = 0; $i < 300; $i++) {
                    $save = Save::create([
                        'user_id' => 1,
                        'foreign_id' => 1,
                    ]);
                    $save->delete();
                }
                break;

            case 'subscribe':
                for ($i = 0; $i < 300; $i++) {
                    $subscribe = Subscribe::create([
                        'user_id' => 1,
                        'type' => 'demo',
                        'tag' => 'demo',
                    ]);
                    $subscribe->delete();
                }
                break;
            
            default:
                # code...
                break;
        }

        return view('layouts.about-us');
    }

    public function contact()
    {
        return view('layouts.contact');
    }

    public function terms()
    {
        return view('layouts.terms');
    }

    public function policies()
    {
        return view('layouts.policies');
    }

    public function copyright(Request $request)
    {
        if ($request->lang == 'en') {
            return view('layouts.copyright-en');
        } else {
            return view('layouts.copyright-ch');
        }
    }

    public function userReport(Request $request)
    {
        $request->validate([
            'userReportReason' => 'required'
        ]);
        $reason = request('userReportReason');
        if ($reason == '其他原因') {
            $reason = $reason.'：'.request('others-text');
        }
        $video = Video::find(request('video-id'));
        Mail::to('laughseejapan@gmail.com')->send(new UserReport($reason, $video));
        return Redirect::back()->withErrors('感謝您向我們提供意見或回報任何錯誤。');
    }

    public function copyrightReport(Request $request)
    {
        Mail::to(['acura1989akc@gmail.com', 'laughseejapan@gmail.com'])->send(new CopyrightReport($request));
        return Redirect::back()->withErrors('Your complaint has been submitted successfully. We will handle accordingly and email you the latest progress.');
    }

    public function sitemap()
    {
        $videos = Video::orderBy('created_at', 'desc')->get();
        $watches = Watch::orderBy('created_at', 'desc')->get();
        $time = Carbon::now()->format('Y-m-d\Th:i:s').'+00:00';
        return Response::view('layouts.sitemap', compact('videos', 'watches', 'time'))->header('Content-Type', 'application/xml');
    }

    public function check(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $videos = Video::where('outsource', false)->orderBy('id', 'desc')->paginate(1);
            $count = Video::where('outsource', false)->orderBy('id', 'desc')->count();

            if ($request->ajax()) {
                return response()->json([
                    'id' => $videos->first()->id,
                    'title' => $videos->first()->title,
                    'link' => $videos->first()->source(),
                    'count' => $count,
                ]);
            }

            return view('layouts.checkVideos', compact('videos'));

        } else {
            return redirect()->action('HomeController@index');
        }
        /*if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $videos = Video::where('outsource', false)->where('sd', 'not like', "%.m3u8%")->orderBy('id', 'desc')->get();
            echo "Video Check STARTED<br>";
            foreach ($videos as $video) {
                foreach ($video->sd() as $url) {
                    if (strpos($url, 'https://www.instagram.com/p/') !== false) {
                        $url = $video->getSourceIG($url);
                        $headers = get_headers($url);
                        $http_response_code = substr($headers[0], 9, 3);
                        if (!($http_response_code == 200)) {
                          echo "<span style='color:red; font-weight:600;'>/watch?v=".$video->id."【".$video->title."】</span><br>";
                        }
                    } elseif (strpos($url, 'https://api.bilibili.com/') !== false) {
                        $curl_connection = curl_init($url);
                        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl_connection, CURLOPT_HTTPHEADER, [
                            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:56.0) Gecko/20100101 Firefox/56.0',
                            'Host: api.bilibili.com',
                            'Cookie: SESSDATA=1feadc09%2C1582358038%2Ca8f2f511;'
                        ]);
                        $data = json_decode(curl_exec($curl_connection), true);
                        curl_close($curl_connection);
                        if (!array_key_exists('data', $data) || !array_key_exists('durl', $data['data'])) {
                            echo "<span style='color:red; font-weight:600;'>/watch?v=".$video->id."【".$video->title."】</span><br>";
                        }
                    }
                }
            }
            echo "Video Check ENDED<br>";
            
        } else {
            return redirect()->action('HomeController@index');
        }*/
    }

    public function checkSubscribes(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            if ($request->has('c')) {
                $category = $request->c;
                $subscribes = Subscribe::where('tag', $category)->get();

                return view('layouts.checkSubscribesCategory', compact('subscribes'));
                
            } else {
                $subscribes = Subscribe::all();
                $rankings = [];
                foreach ($subscribes as $subscribe) {
                    $exist = false;
                    $position = 0;
                    $i = 0;
                    foreach ($rankings as $rank) {
                        if ($rank['tag'] == $subscribe->tag) {
                            $exist = true;
                            $position = $i;
                            break;
                        }
                        $i++;
                    }
                    if ($exist) {
                        $rankings[$i]['count'] = $rankings[$i]['count'] + 1;
                    } else {
                        array_push($rankings, ['tag' => $subscribe->tag, 'count' => 1]);
                    }
                }
                usort($rankings, function ($a, $b) {
                    return $b['count'] <=> $a['count'];
                });

                return view('layouts.checkSubscribes', compact('rankings'));
            }

        } else {
            return redirect()->action('HomeController@index');
        }
    }

    public function checkZeroSubscribes(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {

            $watches = Watch::all();
            $rankings = [];
            foreach ($watches as $watch) {
                if ($watch->subscribes()->count() == 0) {
                    array_push($rankings, ['tag' => $watch->title, 'count' => 0]);
                }
            }

            return view('layouts.checkSubscribes', compact('rankings'));

        } else {
            return redirect()->action('HomeController@index');
        }
    }

    public function videoDurationUpdate(Request $request)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $video = Video::find(Input::get('video'));
        $video->duration = Input::get('dura');
        $out->writeln("Duration is ".Input::get('dura'));
        $video->save();
        return $video;
    }

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
