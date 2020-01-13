<?php

namespace App\Http\Controllers;

use App\Video;
use App\Watch;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;

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

    public function sitemap()
    {
        $videos = Video::orderBy('created_at', 'desc')->get();
        $watches = Watch::orderBy('created_at', 'desc')->get();
        $time = Carbon::now()->format('Y-m-d\Th:i:s').'+00:00';
        return Response::view('layouts.sitemap', compact('videos', 'watches', 'time'))->header('Content-Type', 'application/xml');
    }

    public function check()
    {
        $videos = Video::where('outsource', false)->orderBy('id', 'asc')->get();
        echo "Video Check STARTED<br>";
        foreach ($videos as $video) {
            $url = $video->sd;
            if (strpos($url, 'google') !== false) {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_NOBODY, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $headers = curl_exec($ch);
                curl_close($ch);
                if (preg_match('/^Location: (.+)$/im', $headers, $matches)) {
                    $url = trim($matches[1]);
                }
            }
            $headers = get_headers($url);
            $http_response_code = substr($headers[0], 9, 3);
            if (!($http_response_code == 200)) {
              echo "<span style='color:red; font-weight:600;'>/watch?v=".$video->id." FAILED</span><br>";
            }
        }
        echo "Video Check ENDED<br>";
    }
}
