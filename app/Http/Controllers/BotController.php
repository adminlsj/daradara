<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use Mail;
use App\Mail\UserReport;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;
use App\Helper;

class BotController extends Controller
{
    public function setVideoDuration(Request $request)
    {
        $video = Video::find($request->id);
        $video->duration = round($request->duration);
        $video->save();
    }

    public function updateSpankbang(Request $request)
    {
        $videos = Video::where('foreign_sd', 'ilike', '%"spankbang"%')->select('id', 'title', 'sd', 'outsource', 'tags', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {

            $pass = false;
            $sd = '';
            $source = '';
            $default = '';
            $qualities = [];

            $requests = Browsershot::url($video->foreign_sd['spankbang'])
                ->useCookies(['username' => 'admin'])
                ->timeout(3600)
                ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                ->triggeredRequests();

            foreach ($requests as $request) {
                if (strpos($request['url'], 'p.mp4') !== false) {
                    $sd = $request['url'];
                    $source = $request['url'];
                    $pass = true;
                }
            }

            if ($pass) {
                if (strpos($video->tags, '1080p') !== false) {
                    $sd = str_replace('-720p.mp4', '-1080p.mp4', $sd);
                    $qualities['1080'] = $sd;
                }
                if (strpos($source, '720p') !== false) {
                    $qualities['720'] = $source;
                    $source = str_replace('-720p.mp4', '-480p.mp4', $source);
                }
                if (strpos($source, '480p') !== false) {
                    $qualities['480'] = $source;
                    $source = str_replace('-480p.mp4', '-240p.mp4', $source);
                }
                if (strpos($source, '240p') !== false) {
                    $qualities['240'] = $source;
                }

                $video->sd = reset($qualities);
                $video->qualities = $qualities;
                $video->outsource = false;
                $video->save();

            } else {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Spankbang update failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                $temp = $video->foreign_sd;
                $temp['error'] = $video->foreign_sd['spankbang'];
                unset($temp['spankbang']);
                $video->foreign_sd = $temp;
                $video->save();
            }

        }
    }

    public function updateYoujizz(Request $request)
    {
        Log::info('Youjizz update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"youjizz"%')->select('id', 'title', 'sd', 'outsource', 'foreign_sd')->get();
        foreach ($videos as $video) {
            echo 'ID: '.$video->id.' STARTED<br>';
            $has_hls2e = true;
            $url = $video->foreign_sd['youjizz'];
            $url = explode('/', $url);
            $base = array_pop($url);
            $url = implode('/', $url) . '/' . urlencode($base);

            $loop = 0;
            $link = 'https://cdnc-videos.youjizz.com/';
            $data = [];
            $exist = true;
            while (strpos($link, 'https://cdnc-videos.youjizz.com/') !== false && $loop < 10) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                $start = explode('var dataEncodings = ', $html);
                $innerLoop = 0;
                while (!isset($start[1]) && $innerLoop < 100) {
                    $curl_connection = curl_init($url);
                    curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                    curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                    $html = curl_exec($curl_connection);
                    curl_close($curl_connection);
                    $start = explode('var dataEncodings = ', $html);
                    
                    $innerLoop++;
                    echo 'cdnc loop: '.$loop.'; offset loop: '.$innerLoop.'<br>';
                }

                if (isset($start[1])) {
                    $end = explode(';' , $start[1]);
                    $raw = $end[0];
                    $data = json_decode($raw, true);
                    if (strpos($raw, 'hls2e-') === false) {
                        $has_hls2e = false;
                        $link = '';
                    } else {
                        $target = $data[floor(count($data) / 2) - 1];
                        $link = 'https:'.$target['filename'];
                    }
                    $loop++;

                } else {
                    $exist = false;
                    break;
                }
            }

            if ($exist) {
                $m3u8 = [];
                $mp4 = [];
                foreach ($data as $source) {
                    if (strpos($source['filename'], '.m3u8') === false && is_numeric($source['quality'])) {
                        $mp4[$source['quality']] = 'https:'.$source['filename'];
                    }
                    if (strpos($source['filename'], '.m3u8') !== false && is_numeric($source['quality'])) {
                        $m3u8[$source['quality']] = 'https:'.$source['filename'];
                    }
                }

                if ($has_hls2e) {
                    $video->sd = end($mp4);
                } else {
                    $video->sd = end($m3u8);
                }

                $video->qualities = $mp4;
                $video->outsource = false;
                $video->save();
                echo 'ID: '.$video->id.' UPDATED<br>';

            } else {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Youjizz update failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                $temp = $video->foreign_sd;
                $temp['error'] = $video->foreign_sd['youjizz'];
                unset($temp['youjizz']);
                $video->foreign_sd = $temp;
                $video->save();
                echo 'ID: '.$video->id.' FAILED<br>';
            }
        }

        Log::info('Youjizz update ended...');
    }

    public function updateXvideos(Request $request)
    {
        Log::info('Xvideos update started...');

        $videos = Video::where('sd', 'ilike', '%xvideos%')->where('foreign_sd', 'ilike', '%"xvideos"%')->orderBy('id', 'desc')->get();
        foreach ($videos as $video) {
            $curl_connection = curl_init($video->foreign_sd['xvideos']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            if (strpos($html, "html5player.setVideoHLS('") !== false) {
                $m3u8 = Helper::get_string_between($html, "html5player.setVideoHLS('", "');");
                $curl_connection = curl_init($m3u8);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $data = curl_exec($curl_connection);
                curl_close($curl_connection);

                $array = explode('#EXT-X-STREAM-INF', $data);
                array_shift($array);

                $qualities = [];
                $m3u8_array = explode('/', $m3u8);
                array_pop($m3u8_array);
                $preset = implode('/', $m3u8_array).'/';
                foreach ($array as $item) {
                    $quality = Helper::get_string_between($item, 'NAME="', '"');
                    $source = $preset.trim(explode('NAME="'.$quality.'"', $item)[1]);
                    $qualities[str_replace('p', '', $quality)] = $source;
                }
                if (array_key_exists(1080, $qualities)) {
                   $video->sd = $qualities[1080];
                } elseif (array_key_exists(720, $qualities)) {
                    $video->sd = $qualities[720];
                } elseif (array_key_exists(480, $qualities)) {
                    $video->sd = $qualities[480];
                } elseif (array_key_exists(360, $qualities)) {
                    $video->sd = $qualities[360];
                } elseif (array_key_exists(250, $qualities)) {
                    $video->sd = $qualities[250];
                }

                $video->outsource = false;
                $video->save();

            } else {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Xvideos update failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                $temp = $video->foreign_sd;
                $temp['error'] = $video->foreign_sd['xvideos'];
                unset($temp['xvideos']);
                $video->foreign_sd = $temp;
                $video->save();
            }
        }

        Log::info('Xvideos update ended...');
    }
}
