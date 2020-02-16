<?php

namespace App\Http\Controllers;

use App\Video;
use App\Watch;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use Mail;
use App\Mail\UserReport;
use Redirect;

class HomeController extends Controller
{
    public function aboutUs()
    {
        $is_program = false;
        return view('layouts.about-us', compact('is_program'));
    }

    public function policy()
    {
        $is_program = false;
        return view('layouts.policy', compact('is_program'));
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

    public function sitemap()
    {
        $videos = Video::orderBy('created_at', 'desc')->get();
        $watches = Watch::orderBy('created_at', 'desc')->get();
        $time = Carbon::now()->format('Y-m-d\Th:i:s').'+00:00';
        return Response::view('layouts.sitemap', compact('videos', 'watches', 'time'))->header('Content-Type', 'application/xml');
    }

    public function check()
    {
        $videos = Video::where('outsource', false)->where('sd', 'not like', "%.m3u8%")->orderBy('id', 'asc')->get();
        echo "Video Check STARTED<br>";
        foreach ($videos as $video) {
            foreach ($video->sd() as $url) {
                if (strpos($url, 'https://www.instagram.com/p/') !== false) {
                    $url = $video->getSourceIG($url);
                } elseif (strpos($url, 'https://api.bilibili.com/') !== false) {
                    echo $video->getSourceBB($url);
                }
                $headers = get_headers($url);
                $http_response_code = substr($headers[0], 9, 3);
                if (!($http_response_code == 200)) {
                  echo "<span style='color:red; font-weight:600;'>/watch?v=".$video->id."【".$video->title."】</span><br>";
                }
            }
        }
        echo "Video Check ENDED<br>";
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
        $is_program = false;
        return view('video.singleNewCreate', compact('is_program')); 
    }

    public function singleNewStore(Request $request)
    {
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
        ]);

        $watch = $video->watch();
        $watch->updated_at = $video->created_at;
        $watch->save();

        return redirect()->action('HomeController@singleNewCreate', ['is_program' => false]);
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
