<?php

namespace App;

use Mail;
use App\Video;
use App\Helper;
use Carbon\Carbon;
use App\Mail\UserReport;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;

class Youjizz
{
    public static function updateYoujizzDownloads()
    {
        Log::info('Youjizz downloads update started...');

        $videos = Video::where('foreign_sd', 'like', '%"downloadY"%')->select('id', 'title', 'sd', 'outsource', 'foreign_sd')->get();
        foreach ($videos as $video) {
            echo 'ID: '.$video->id.' DOWNLOAD STARTED<br>';
            Log::info('ID: '.$video->id.' started');
            $url = $video->foreign_sd['downloadY'];
            $url = explode('/', $url);
            $base = array_pop($url);
            $url = implode('/', $url) . '/' . urlencode($base);

            $loop = 0;
            $html = '';
            $start = '';
            while (strpos($html, 'var dataEncodings = ') === false && $loop < 100) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                Log::info("ID#{$video->id} html loop {$loop} failed");
                $loop++;
            }
            if (strpos($html, 'var dataEncodings = ') !== false) {
                $start = explode('var dataEncodings = ', $html);
                $end = explode(';' , $start[1]);
                $raw = $end[0];
                $data = json_decode($raw, true);

                $mp4 = [];
                foreach ($data as $source) {
                    if (strpos($source['filename'], '.m3u8') === false && is_numeric($source['quality']) && strpos($source['filename'], 'cdn2e') === false) {
                        $mp4[$source['quality']] = 'https:'.$source['filename'];
                    }
                }

                $video->downloads = $mp4;
                $video->save();
                echo 'ID: '.$video->id.' DOWNLOAD UPDATED<br>';
                Log::info('ID: '.$video->id.' updated');

            } else {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Youjizz download failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                $temp = $video->foreign_sd;
                $temp['errorDY'] = $video->foreign_sd['downloadY'];
                unset($temp['downloadY']);
                $video->foreign_sd = $temp;
                $video->save();
                echo 'ID: '.$video->id.' DOWNLOAD FAILED<br>';
                Log::info('ID: '.$video->id.' failed');
            }
        }

        Log::info('Youjizz downloads update ended...');

        Log::info('Youjizz sc downloads update started...');

        $videos = Video::where('foreign_sd', 'like', '%"downloadY_sc"%')->select('id', 'title', 'sd', 'outsource', 'foreign_sd')->get();
        foreach ($videos as $video) {
            echo 'ID: '.$video->id.' DOWNLOAD STARTED<br>';
            Log::info('ID: '.$video->id.' sc started');
            $url = $video->foreign_sd['downloadY_sc'];
            $url = explode('/', $url);
            $base = array_pop($url);
            $url = implode('/', $url) . '/' . urlencode($base);

            $loop = 0;
            $html = '';
            $start = '';
            while (strpos($html, 'var dataEncodings = ') === false && $loop < 100) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                Log::info("ID#{$video->id} html loop {$loop} failed");
                $loop++;
            }
            if (strpos($html, 'var dataEncodings = ') !== false) {
                $start = explode('var dataEncodings = ', $html);
                $end = explode(';' , $start[1]);
                $raw = $end[0];
                $data = json_decode($raw, true);

                $mp4 = [];
                foreach ($data as $source) {
                    if (strpos($source['filename'], '.m3u8') === false && is_numeric($source['quality']) && strpos($source['filename'], 'cdn2e') === false) {
                        $mp4[$source['quality']] = 'https:'.$source['filename'];
                    }
                }

                $video->downloads_sc = $mp4;
                $video->save();
                echo 'ID: '.$video->id.' SC DOWNLOAD UPDATED<br>';
                Log::info('ID: '.$video->id.' sc updated');

            } else {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Youjizz sc download failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                $temp = $video->foreign_sd;
                $temp['errorDY_sc'] = $video->foreign_sd['downloadY_sc'];
                unset($temp['downloadY_sc']);
                $video->foreign_sd = $temp;
                $video->save();
                echo 'ID: '.$video->id.' SC DOWNLOAD FAILED<br>';
                Log::info('ID: '.$video->id.' sc failed');
            }
        }

        Log::info('Youjizz sc downloads update ended...');
    }
}
