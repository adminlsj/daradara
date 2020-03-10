<?php

namespace App\Http\Controllers;

use App\Video;
use App\Watch;
use App\Subscribe;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use Mail;
use Auth;
use App\Mail\UserReport;
use App\Mail\UserUploadVideo;
use App\Mail\SubscribeNotify;
use Redirect;

class HomeController extends Controller
{
    public function aboutUs()
    {
        $url = 'https://www.bilibili.com/video/av95065476';
        $page = 1;
        if (($pos = strpos($url, "?p=")) !== FALSE) { 
            $page = substr($url, $pos + 3);
            $url = str_replace("?p=".$page, "", $url);
        }
        if (($pos = strpos($url, "av")) !== FALSE) { 
            $aid = substr($url, $pos + 2); 
        }
        try {
            $curl_connection = curl_init("https://api.bilibili.com/x/web-interface/view?aid=".$aid);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $data = json_decode(curl_exec($curl_connection), true);
            $cid = $data['data']['pages'][$page - 1]["cid"];
            curl_close($curl_connection);

            $url = "https://api.bilibili.com/x/player/playurl?avid=".$aid."&cid=".$cid."&qn=0&type=mp4&otype=json&fnver=0&fnval=1&platform=html5&html5=1&high_quality=1";

            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_connection, CURLOPT_HTTPHEADER, [
                'Referer: https://www.bilibili.com/video/av95065476',
                'X-Forwarded-For: http://127.0.0.1:8000/',
            ]);
            return $data = json_decode(curl_exec($curl_connection), true);
            curl_close($curl_connection);

            $durl = $data['data']['durl'][0];
            $url = $durl['url'];
            if ($durl['backup_url'] != null && strpos($durl['backup_url'][0], 'upos-hz-mirrorakam') !== false) {
                $url = $durl['backup_url'][0];
            }

            return $url;
        } catch(Exception $e) {
            return $e->getMessage();
        }
        $is_program = false;
        return view('layouts.about-us', compact('is_program'));
    }

    public function terms()
    {
        $is_program = false;
        return view('layouts.terms', compact('is_program'));
    }

    public function policies()
    {
        $is_program = false;
        return view('layouts.policies', compact('is_program'));
    }

    public function copyright()
    {
        $is_program = false;
        return view('layouts.copyright', compact('is_program'));
    }

    public function userReport(Request $request)
    {
        $request->validate([
            'userReportReason' => 'required'
        ]);
        $reason = request('userReportReason');
        $video = Video::find(request('video-id'));
        Mail::to('laughseejapan@gmail.com')->send(new UserReport($reason, $video));
        return Redirect::back()->withErrors('感謝您向我們提供意見或回報任何錯誤。');
    }

    public function userUploadVideo(Request $request)
    {
        $genre = request('channel-genre');
        $category = request('channel-category');
        $title = request('video-title');
        $description = request('video-description');
        $image = request('video-image');
        $link = request('video-link');

        $user = auth()->user();
        Mail::to('laughseejapan@gmail.com')->send(new UserUploadVideo($user, $genre, $category, $title, $description, $image, $link));
        return Redirect::back()->withErrors('影片將在系統處理完畢後自動上傳');   
    }

    public function sitemap()
    {
        $videos = Video::orderBy('created_at', 'desc')->get();
        $watches = Watch::orderBy('created_at', 'desc')->get();
        $time = Carbon::now()->format('Y-m-d\Th:i:s').'+00:00';
        return Response::view('layouts.sitemap', compact('videos', 'watches', 'time'))->header('Content-Type', 'application/xml');
    }

    public function check()
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $videos = Video::where('outsource', false)->where('sd', 'not like', "%.m3u8%")->orderBy('id', 'asc')->get();
            echo "Video Check STARTED<br>";
            foreach ($videos as $video) {
                foreach ($video->sd() as $url) {
                    if (strpos($url, 'https://www.instagram.com/p/') !== false) {
                        $url = $video->getSourceIG($url);
                    } elseif (strpos($url, 'https://api.bilibili.com/') !== false) {
                        echo $video->getSourceBB($url);
                        echo '<br>';
                    }
                    $headers = get_headers($url);
                    $http_response_code = substr($headers[0], 9, 3);
                    if (!($http_response_code == 200)) {
                      echo "<span style='color:red; font-weight:600;'>/watch?v=".$video->id."【".$video->title."】</span><br>";
                    }
                }
            }
            echo "Video Check ENDED<br>";
            
        } else {
            return redirect()->action('VideoController@home');
        }
    }

    public function checkSubscribes(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            if ($request->has('c')) {
                $category = $request->c;
                $subscribes = Subscribe::where('category', $category)->get();

                return view('layouts.checkSubscribesCategory', compact('subscribes'));
                
            } else {
                $watches = Watch::all();
                $rankings = [];
                foreach ($watches as $watch) {
                    $subscribes = $watch->subscribes()->count();
                    array_push($rankings, ['subscribes' => $subscribes, 'id' => $watch->id]);
                }
                usort($rankings, function ($a, $b) {
                    return $b['subscribes'] <=> $a['subscribes'];
                });

                $sortedWatches = [];
                foreach ($rankings as $rank) {
                    array_push($sortedWatches, Watch::find($rank['id']));
                }

                return view('layouts.checkSubscribes', compact('sortedWatches'));
            }

        } else {
            return redirect()->action('VideoController@home');
        }
    }

    public function categoryEdit()
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
            return redirect()->action('VideoController@home');
        }
    }

    public function singleNewStore(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $latest = Video::where('category', request('category'))->orderBy('created_at', 'desc')->first();
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
                'duration' => $latest->duration,
                'outsource' => false,
                'created_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('created_at'))->format('Y-m-d H:i:s'),
                'uploaded_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('uploaded_at'))->format('Y-m-d H:i:s'),
            ]);

            $watch = $video->watch();
            $watch->updated_at = $video->uploaded_at;
            $watch->save();

            $subscribes = $watch->subscribes();
            foreach ($subscribes as $subscribe) {
                $user = $subscribe->user();
                Mail::to($user->email)->send(new SubscribeNotify($user, $video));
            }

            return redirect()->action('HomeController@singleNewCreate', ['is_program' => false]);

        } else {
            return redirect()->action('VideoController@home');
        }
    }

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function bccToSrt(String $url){
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
}
