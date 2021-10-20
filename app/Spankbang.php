<?php

namespace App;

use Mail;
use App\Video;
use App\Helper;
use Carbon\Carbon;
use App\Mail\UserReport;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;

class Spankbang
{
    public static function updateSpankbang()
    {
        Log::info('Spankbang update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"spankbang"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {

            $curl_connection = curl_init($video->foreign_sd['spankbang']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $sd = Helper::get_string_between($html, '"contentUrl": "', '"');
            $source = Helper::get_string_between($html, '"contentUrl": "', '"');
            $qualities = [];

            if (strpos($sd, 'https://vdownload') !== false) {
                if (in_array('1080p', array_keys($video->tags_array))) {
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

            sleep(10);
        }

        /* $videos = Video::where('foreign_sd', 'ilike', '%"spankbang"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

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
                if (in_array('1080p', array_keys($video->tags_array))) {
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
        } */

        Log::info('Spankbang update ended...');
    }

    public static function updateSpankbangBackup()
    {
        Log::info('Spankbang backup update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"spankbang"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        $base = Carbon::now()->addHours(4)->timestamp;

        foreach ($videos as $video) {
            $time = Helper::get_string_between($video->sd, ',', '&m=');
            if ($time < $base) {
                $pass = false;
                $sd = '';
                $source = '';
                $qualities = [];

                // curl connection
                /* $curl_connection = curl_init($video->foreign_sd['spankbang']);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection); */

                // browsershot
                $html = Browsershot::url($video->foreign_sd['spankbang'])
                        ->timeout(3600)
                        ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                        ->bodyHtml();

                $sd = Helper::get_string_between($html, '"contentUrl": "', '"');
                $source = Helper::get_string_between($html, '"contentUrl": "', '"');
                if (strpos($sd, 'https://vdownload') !== false) {
                    $pass = true;
                }

                if ($pass) {
                    if (in_array('1080p', array_keys($video->tags_array))) {
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

                sleep(5);
            }
        }

        Log::info('Spankbang backup update ended...');
    }

    public static function updateSpankbangErrors()
    {
        Log::info('Spankbang errors update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"error"%')->where('foreign_sd', 'ilike', '%spankbang%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {

            if (array_key_exists("error", $video->foreign_sd) && strpos($video->foreign_sd["error"], 'spankbang') !== false ) {
                $pass = false;
                $sd = '';
                $source = '';
                $qualities = [];

                /* $requests = Browsershot::url($video->foreign_sd["error"])
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
                } */

                $curl_connection = curl_init($video->foreign_sd['error']);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                $sd = Helper::get_string_between($html, '"contentUrl": "', '"');
                $source = Helper::get_string_between($html, '"contentUrl": "', '"');
                if (strpos($sd, 'https://vdownload') !== false) {
                    $pass = true;
                }

                if ($pass) {
                    if (in_array('1080p', array_keys($video->tags_array))) {
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

                    $temp = $video->foreign_sd;
                    $temp['spankbang'] = $video->foreign_sd['error'];
                    unset($temp['error']);
                    $video->foreign_sd = $temp;
                    $video->sd = reset($qualities);
                    $video->qualities = $qualities;
                    $video->outsource = false;
                    $video->save();

                } else {
                    Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Spankbang update failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                }

                sleep(10);
            }
        }

        Log::info('Spankbang errors update ended...');
    }

    public static function checkSpankbangOutdate()
    {
        $items = 0;
        $base = Carbon::now()->addHours(6)->timestamp;
        $videos = Video::where('foreign_sd', 'ilike', '%"spankbang"%')->select('id', 'title', 'sd', 'foreign_sd', 'created_at')->get();
        foreach ($videos as $video) {
            $time = Helper::get_string_between($video->sd, ',', '&m=');
            if ($time < $base) {
                echo $time.'<br>';
                $items++;
            }
        }
        echo $items;
    }

    public static function checkSpankbangUpdate()
    {
        $items = 0;
        $base = Carbon::now()->addHours(9)->timestamp;
        $videos = Video::where('foreign_sd', 'ilike', '%"spankbang"%')->select('id', 'title', 'sd', 'foreign_sd', 'created_at')->get();
        foreach ($videos as $video) {
            $time = Helper::get_string_between($video->sd, ',', '&m=');
            if ($time > $base) {
                echo $time.'<br>';
                $items++;
            }
        }
        echo $items;
    }
}
