<?php

namespace App\Http\Controllers;

use App\Video;
use App\Watch;
use App\Subscribe;
use App\User;
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

    public function about()
    {
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

    /* public function categoryEdit()
    {
        $is_program = false;
        return view('video.categoryEdit', compact('is_program')); 
    }

    public function categoryUpdate(Request $request)
    {
        $videos = Video::where('category', request('category'))->orderBy('created_at', 'asc')->get();
        $links = request('sourceLinks');
        $links = preg_split('/\r\n|\r|\n/', $links);

        for ($i = 0; $i < count($links); $i++) { 
            $links[$i] = trim($links[$i]);
            if (($pos = strpos($links[$i], "$")) !== FALSE) { 
                $links[$i] = trim(substr($links[$i], $pos + 1));
            }
        }

        for ($i = 0; $i < count($videos); $i++) { 
            $videos[$i]->sd = $links[$i];
            $videos[$i]->hd = $links[$i];
            $videos[$i]->outsource = true;
            $videos[$i]->save();
        }

        return redirect()->action('HomeController@categoryEdit', ['is_program' => false]);
    }

    public function singleNewCreate()
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $is_program = false;
            return view('video.singleNewCreate', compact('is_program')); 

        } else {
            return redirect()->action('HomeController@index');
        }
    }

    public function singleNewStore(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $latest = Video::where('category', request('category'))->orderBy('uploaded_at', 'desc')->first();
            $title = request('title');
            if ($title == "") {
                $prevEpisode = $this->get_string_between($latest->title, '【第', '話】');
                $episode = $prevEpisode;
                if (is_numeric($prevEpisode) && floor($prevEpisode) != $prevEpisode) {
                    $episode = $prevEpisode + 0.5;
                } else {
                    $episode = $prevEpisode + 1;
                }
                $title = str_replace($prevEpisode, $episode, $latest->title);
            }

            $video = Video::create([
                'id' => Video::orderBy('id', 'desc')->first()->id + 1,
                'title' => $title,
                'caption' => request('caption'),
                'hd' => request('link'),
                'sd' => request('link'),
                'imgur' => request('imgur'),
                'genre' => $latest->genre,
                'category' => $latest->category,
                'season' => $latest->season,
                'tags' => request('tags') == "" ? $latest->tags : request('tags'),
                'views' => request('views') == "" ? $latest->views : request('views'),
                'duration' => request('duration') == "" ? $latest->duration : request('duration'),
                'outsource' => false,
                'created_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('created_at'))->format('Y-m-d H:i:s'),
                'uploaded_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('uploaded_at'))->format('Y-m-d H:i:s'),
            ]);

            foreach ($video->sd() as $sd) {
                $video->sd = str_replace($sd, Video::getLinkBB($sd, $video->outsource), $video->sd);
                $video->save();
            }

            $users = [];
            $userArray = [];

            if ($video->category != 'video') {
                $watch = $video->watch();
                $watch->updated_at = $video->uploaded_at;
                $watch->save();

                $subscribes = $watch->subscribes();
                foreach ($subscribes as $subscribe) {
                    $user = $subscribe->user();
                    array_push($userArray, $user->id);
                }
            }

            foreach ($video->tags() as $tag) {
                $subscribes = Subscribe::where('tag', $tag)->get();
                foreach ($subscribes as $subscribe) {
                    if (!in_array($subscribe->user()->id, $userArray)) {
                        array_push($userArray, $subscribe->user()->id);
                    }
                }
            }

            foreach ($userArray as $user_id) {
                array_push($users, User::find($user_id));
            }

            foreach ($users as $user) {
                Mail::to($user->email)->send(new SubscribeNotify($user, $video));
                if (strpos($user->alert, 'subscribe') === false) {
                    $user->alert = $user->alert."subscribe";
                    $user->save();
                }
            }

            return redirect()->action('HomeController@singleNewCreate');

        } else {
            return redirect()->action('HomeController@index');
        }
    } */

    public function videoDurationUpdate(Request $request)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $video = Video::find(Input::get('video'));
        $video->duration = Input::get('dura');
        $out->writeln("Duration is ".Input::get('dura'));
        $video->save();
        return $video;
    }

    /* public function bccToSrt(Request $request){
        $url = request('url');
        try {
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $data = json_decode(curl_exec($curl_connection), true);
            curl_close($curl_connection);

            for ($i=0; $i < count($data['body']); $i++) { 
                $current = $data['body'][$i];
                echo ($i + 1).'<br>';

                $from_seconds = floor($current['from']);
                $from_miliseconds = floor(($current['from'] - floor($current['from'])) * 1000);
                if ($from_miliseconds < 100) {
                    $from_miliseconds = $from_miliseconds.'0';
                }

                $from_hours = floor($from_seconds / 3600);
                $from_mins = floor($from_seconds / 60 % 60);
                $from_secs = floor($from_seconds % 60);

                if ($from_hours < 10) {
                    $from_hours = '0'.$from_hours;
                }
                if ($from_mins < 10) {
                    $from_mins = '0'.$from_mins;
                }
                if ($from_secs < 10) {
                    $from_secs = '0'.$from_secs;
                }

                $to_seconds = floor($current['to']);
                $to_miliseconds = ($current['to'] - floor($current['to'])) * 1000;
                $to_miliseconds = floor(($current['from'] - floor($current['from'])) * 1000);
                if ($to_miliseconds < 100) {
                    $to_miliseconds = $to_miliseconds.'0';
                }
                
                $to_hours = floor($to_seconds / 3600);
                $to_mins = floor($to_seconds / 60 % 60);
                $to_secs = floor($to_seconds % 60);

                if ($to_hours < 10) {
                    $to_hours = '0'.$to_hours;
                }
                if ($to_mins < 10) {
                    $to_mins = '0'.$to_mins;
                }
                if ($to_secs < 10) {
                    $to_secs = '0'.$to_secs;
                }

                echo $from_hours.':'.$from_mins.':'.$from_secs.','.$from_miliseconds.' --> '.$to_hours.':'.$to_mins.':'.$to_secs.','.$to_miliseconds.'<br>';

                echo $current['content'];
                echo '<br>';
                echo '<br>';
            }

        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function tempMethods()
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $videos = Video::all();
            foreach ($videos as $video) {
                $loop = 0;
                foreach ($video->sd() as $url) {
                    if (strpos($url, "api.bilibili.com") !== FALSE) {
                        $avid = '';
                        $bvid = '';
                        $cid = '';
                        $page = 1;
                        if (strpos($url, "avid=") !== FALSE) { 
                            $avid = $this->get_string_between($url, 'avid=', '&');
                        }
                        if (strpos($url, "bvid=") !== FALSE) { 
                            $bvid = $this->get_string_between($url, 'bvid=', '&');
                        }
                        if (strpos($url, "cid=") !== FALSE) { 
                            $cid = $this->get_string_between($url, 'cid=', '&');
                        }
                        if (($pos = strpos($video->hd, "?p=")) !== FALSE) { 
                            $page = substr($video->hd, $pos + 3);
                        }

                        $video->sd = str_replace($url, '//player.bilibili.com/player.html?aid='.$avid.'&bvid='.$bvid.'&cid='.$cid.'&page='.$page.'&danmaku=0&qn=0&type=mp4&otype=json&fnver=0&fnval=1&platform=html5&html5=1&high_quality=1', $video->sd);
                        $video->outsource = true;
                        $video->save();
                    }
                    $loop++;
                }
            }
        }
        return redirect()->action('HomeController@Index');
    } */

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
