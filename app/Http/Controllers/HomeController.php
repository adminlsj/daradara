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
                    try {
                        $curl_connection = curl_init($url.'?__a=1');
                        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

                        $data = json_decode(curl_exec($curl_connection), true);
                        curl_close($curl_connection);

                        if ($data === null) {
                            $url = 'https://www.bilibili.com/404error';
                        } else {
                            $url = $data['graphql']['shortcode_media']['video_url'];
                        }
                    } catch(Exception $e) {
                        $url = $e->getMessage();
                    }
                }
                $headers = get_headers($url);
                $http_response_code = substr($headers[0], 9, 3);
                if (!($http_response_code == 200)) {
                  echo "<span style='color:red; font-weight:600;'>/watch?v=".$video->id." FAILED</span><br>";
                }
            }
        }
        echo "Video Check ENDED<br>";
    }
}
