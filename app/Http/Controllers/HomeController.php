<?php

namespace App\Http\Controllers;

use App\Video;
use App\Watch;
use App\Subscribe;
use App\User;
use App\Avatar;
use App\Comment;
use App\Like;
use App\Save;
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
    public function index(Request $request)
    {
        return view('video.home');
    }

    public function loadHomeTagList(Request $request)
    {
        $tag = strpos($request->tag, '全部') !== false ? '' : $request->tag;
        $genre = $request->genre;
        if ($tag == '') {
            switch ($genre) {
                case 'anime':
                    $videos = Video::where(function($query) {
                        $query->orWhere('tags', 'like', '%正版動漫%')->orWhere('tags', 'like', '%動畫%')->orWhere('tags', 'like', '%動漫講評%')->orWhere('tags', 'like', '%MAD·AMV%');
                    })->orderBy('uploaded_at', 'desc')->limit(8)->get();
                    break;

                case 'artist':
                    $videos = Video::where(function($query) {
                        $query->orWhere('tags', 'like', '%明星%');
                    })->orderBy('uploaded_at', 'desc')->limit(8)->get();
                    break;

                case 'youtuber':
                    $videos = Video::where(function($query) {
                        $query->orWhere('tags', 'like', '%日本人氣YouTuber%');
                    })->orderBy('uploaded_at', 'desc')->limit(8)->get();
                    break;
            }

        } else {
            if ($tag == 'anime1') {
                $videos= Video::where('user_id', 746)->orderBy('uploaded_at', 'desc')->limit(8)->get();
            } elseif ($tag == 'Gimy劇迷') {
                $videos= Video::where('user_id', 750)->orderBy('uploaded_at', 'desc')->limit(8)->get();
            } else {
                $videos = Video::where('tags', 'like', '%'.$tag.'%')->orderBy('uploaded_at', 'desc')->limit(8)->get();
            }
        }

        return $this->newSingleLoadMoreSliderVideosHTML($videos);
    }

    public function newSingleLoadMoreSliderVideosHTML($videos)
    {
        $html = '';
        foreach ($videos as $video) {
            $html .= view('video.new-singleLoadMoreVideos', compact('video'));
        }
        return $html;
    }

    public function about(Request $request)
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

    public function videoDurationUpdate(Request $request)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $video = Video::find(Input::get('video'));
        $video->duration = Input::get('dura');
        $out->writeln("Duration is ".Input::get('dura'));
        $video->save();
        return $video;
    }

    /* public function updateSourceToMP4()
    {
        $quan = Video::where('sd', 'like', '%1098_%')->get();
        $qzone = Video::where('sd', 'like', '%1006_%')->get();

        foreach ($quan as $video) {
            $video->sd = Video::getSourceQQ($video->sd);
            $video->save();
        }

        foreach ($qzone as $video) {
            $video->sd = Video::getSourceQZ($video->sd);
            $video->save();
        }

        return "Done";
    } */

    public function tempMethods()
    {

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
