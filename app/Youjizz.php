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
    public static function updateYoujizzSplit($number = 1, $total = 1)
    {
        Log::info('Youjizz update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"youjizz"%')
                    ->select('id', 'title', 'sd', 'outsource', 'foreign_sd')
                    ->orderBy('id', 'desc')
                    ->get()
                    ->split($total)[$number - 1]
                    ->sortBy(function($video){
                        return (int) Helper::get_string_between($video->sd, 'validto=', '&');
                    })
                    ->values()
                    ->slice(0, 3);

        foreach ($videos as $video) {
            echo 'ID: '.$video->id.' STARTED<br>';
            Log::info('ID: '.$video->id.' started');
            $url = $video->foreign_sd['youjizz'];
            $url = explode('/', $url);
            $base = array_pop($url);
            $url = implode('/', $url) . '/' . urlencode($base);

            $loop = 0;
            $html = '';
            $start = '';
            $has_hls2e = true;
            while (strpos($html, 'var dataEncodings = ') === false && $loop < 1000) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                if ($loop > 0) {
                    Log::info("ID#{$video->id} html loop {$loop} failed");
                }
                $loop++;

                // sleep(5);
            }
            if (strpos($html, 'var dataEncodings = ') !== false) {
                $start = explode('var dataEncodings = ', $html);
                $end = explode(';' , $start[1]);
                $raw = $end[0];
                if (strpos($raw, 'hls2e-') === false) {
                    $has_hls2e = false;
                }
                $data = json_decode($raw, true);

                $m3u8 = [];
                $mp4 = [];
                foreach ($data as $source) {
                    if (strpos($source['filename'], '.m3u8') === false && is_numeric($source['quality']) && strpos($source['filename'], 'cdn2e') === false) {
                        $mp4[$source['quality']] = 'https:'.$source['filename'];
                    }
                    if (strpos($source['filename'], '.m3u8') !== false && is_numeric($source['quality'])) {
                        $m3u8[$source['quality']] = 'https:'.$source['filename'];
                    }
                }

                if ($has_hls2e) {
                    $video->sd = end($mp4);
                    $video->outsource = true;
                } else {
                    $video->sd = end($m3u8);
                    $video->outsource = false;
                }
                $video->qualities = $mp4;
                $video->save();
                echo 'ID: '.$video->id.' UPDATED<br>';
                Log::info('ID: '.$video->id.' updated');

                sleep(10);

            } else {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Youjizz update failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                $temp = $video->foreign_sd;
                $temp['error'] = $video->foreign_sd['youjizz'];
                unset($temp['youjizz']);
                $video->foreign_sd = $temp;
                $video->save();
                echo 'ID: '.$video->id.' FAILED<br>';
                Log::info('ID: '.$video->id.' failed');
            }
        }

        Log::info('Youjizz update ended...');
    }

    public static function updateYoujizz()
    {
        Log::info('Youjizz update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"youjizz"%')
                    ->select('id', 'title', 'sd', 'outsource', 'foreign_sd')
                    ->orderBy('id', 'asc')
                    ->get()
                    ->sortBy(function($video){
                        return (int) Helper::get_string_between($video->sd, 'validfrom=', '&');
                    })
                    ->values()
                    ->slice(0, 1);;

        foreach ($videos as $video) {
            echo 'ID: '.$video->id.' STARTED<br>';
            Log::info('ID: '.$video->id.' started');
            $url = $video->foreign_sd['youjizz'];
            $url = explode('/', $url);
            $base = array_pop($url);
            $url = implode('/', $url) . '/' . urlencode($base);

            $loop = 0;
            $html = '';
            $start = '';
            $has_hls2e = true;
            while (strpos($html, 'var dataEncodings = ') === false && $loop < 1000) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                if ($loop > 0) {
                    Log::info("ID#{$video->id} html loop {$loop} failed");
                }
                $loop++;

                // sleep(5);
            }
            if (strpos($html, 'var dataEncodings = ') !== false) {
                $start = explode('var dataEncodings = ', $html);
                $end = explode(';' , $start[1]);
                $raw = $end[0];
                if (strpos($raw, 'hls2e-') === false) {
                    $has_hls2e = false;
                }
                $data = json_decode($raw, true);

                $m3u8 = [];
                $mp4 = [];
                foreach ($data as $source) {
                    if (strpos($source['filename'], '.m3u8') === false && is_numeric($source['quality']) && strpos($source['filename'], 'cdn2e') === false) {
                        $mp4[$source['quality']] = 'https:'.$source['filename'];
                    }
                    if (strpos($source['filename'], '.m3u8') !== false && is_numeric($source['quality'])) {
                        $m3u8[$source['quality']] = 'https:'.$source['filename'];
                    }
                }

                if ($has_hls2e) {
                    $video->sd = end($mp4);
                    $video->outsource = true;
                } else {
                    $video->sd = end($m3u8);
                    $video->outsource = false;
                }
                $video->qualities = $mp4;
                $video->save();
                echo 'ID: '.$video->id.' UPDATED<br>';
                Log::info('ID: '.$video->id.' updated');

            } else {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Youjizz update failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                $temp = $video->foreign_sd;
                $temp['error'] = $video->foreign_sd['youjizz'];
                unset($temp['youjizz']);
                $video->foreign_sd = $temp;
                $video->save();
                echo 'ID: '.$video->id.' FAILED<br>';
                Log::info('ID: '.$video->id.' failed');
            }
        }

        Log::info('Youjizz update ended...');
    }

    public static function updateYoujizzDownloads()
    {
        Log::info('Youjizz downloads update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"downloadY"%')
                    ->select('id', 'title', 'sd', 'downloads', 'outsource', 'foreign_sd')
                    ->orderBy('id', 'asc')
                    ->get()
                    ->sortBy(function($video){
                        return (int) Helper::get_string_between(head($video->downloads), 'validfrom=', '&');
                    })
                    ->values()
                    ->slice(0, 3);

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
            while (strpos($html, 'var dataEncodings = ') === false && $loop < 1000) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                if ($loop > 0) {
                    Log::info("ID#{$video->id} html loop {$loop} failed");
                }
                $loop++;

                // sleep(5);
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

                sleep(10);

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
    }

    public static function updateYoujizzDownloadsSc()
    {
        Log::info('Youjizz downloads sc update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"downloadY_sc"%')
                    ->select('id', 'title', 'sd', 'downloads_sc', 'outsource', 'foreign_sd')
                    ->orderBy('id', 'asc')
                    ->get()
                    ->sortBy(function($video){
                        return (int) Helper::get_string_between(head($video->downloads_sc), 'validfrom=', '&');
                    })
                    ->values()
                    ->slice(0, 3);

        foreach ($videos as $video) {
            echo 'ID: '.$video->id.' DOWNLOAD STARTED<br>';
            Log::info('ID: '.$video->id.' started');
            $url = $video->foreign_sd['downloadY_sc'];
            $url = explode('/', $url);
            $base = array_pop($url);
            $url = implode('/', $url) . '/' . urlencode($base);

            $loop = 0;
            $html = '';
            $start = '';
            while (strpos($html, 'var dataEncodings = ') === false && $loop < 1000) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                if ($loop > 0) {
                    Log::info("ID#{$video->id} html loop {$loop} failed");
                }
                $loop++;

                // sleep(5);
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
                Log::info('ID: '.$video->id.' updated');

                sleep(10);

            } else {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Youjizz sc download failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                $temp = $video->foreign_sd;
                $temp['errorDY_sc'] = $video->foreign_sd['downloadY_sc'];
                unset($temp['downloadY_sc']);
                $video->foreign_sd = $temp;
                $video->save();
                echo 'ID: '.$video->id.' SC DOWNLOAD FAILED<br>';
                Log::info('ID: '.$video->id.' failed');
            }
        }

        Log::info('Youjizz downloads sc update ended...');
    }

    public static function updateYoujizzErrors()
    {
        Log::info('Youjizz errors update started...');

        $videos = Video::where('foreign_sd', 'like', '%"error": "https://www.youjizz.com/videos/%')
                    ->select('id', 'title', 'sd', 'outsource', 'foreign_sd')
                    ->orderBy('id', 'asc')
                    ->get()
                    ->sortBy(function($video){
                        return (int) Helper::get_string_between($video->sd, 'validfrom=', '&');
                    })
                    ->values();

        foreach ($videos as $video) {
            echo 'ID: '.$video->id.' ERROR UPDATE STARTED<br>';
            Log::info('ID: '.$video->id.' started');
            $url = $video->foreign_sd['error'];
            $url = explode('/', $url);
            $base = array_pop($url);
            $url = implode('/', $url) . '/' . urlencode($base);

            $loop = 0;
            $html = '';
            $start = '';
            $has_hls2e = true;
            while (strpos($html, 'var dataEncodings = ') === false && $loop < 1000) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                Log::info("ID#{$video->id} error loop {$loop} failed");
                $loop++;

                // sleep(5);
            }
            if (strpos($html, 'var dataEncodings = ') !== false) {
                $start = explode('var dataEncodings = ', $html);
                $end = explode(';' , $start[1]);
                $raw = $end[0];
                if (strpos($raw, 'hls2e-') === false) {
                    $has_hls2e = false;
                }
                $data = json_decode($raw, true);

                $m3u8 = [];
                $mp4 = [];
                foreach ($data as $source) {
                    if (strpos($source['filename'], '.m3u8') === false && is_numeric($source['quality']) && strpos($source['filename'], 'cdn2e') === false) {
                        $mp4[$source['quality']] = 'https:'.$source['filename'];
                    }
                    if (strpos($source['filename'], '.m3u8') !== false && is_numeric($source['quality'])) {
                        $m3u8[$source['quality']] = 'https:'.$source['filename'];
                    }
                }

                $temp = $video->foreign_sd;
                $temp['youjizz'] = $video->foreign_sd['error'];
                unset($temp['error']);
                $video->foreign_sd = $temp;

                if ($has_hls2e) {
                    $video->sd = end($mp4);
                    $video->outsource = true;
                } else {
                    $video->sd = end($m3u8);
                    $video->outsource = false;
                }
                $video->qualities = $mp4;
                $video->save();
                echo 'ID: '.$video->id.' ERROR UPDATED<br>';
                Log::info('ID: '.$video->id.' error updated');

            } else {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Youjizz error update failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                echo 'ID: '.$video->id.' ERROR UPDATE FAILED<br>';
                Log::info('ID: '.$video->id.' error update failed');
            }
        }
    }

    public static function checkYoujizz()
    {
        $most = [];
        $videos = Video::where('foreign_sd', 'ilike', '%"youjizz"%')
                    ->select('id', 'title', 'sd', 'outsource', 'foreign_sd')
                    ->orderBy('id', 'desc')
                    ->get()
                    ->sortBy(function($video){
                        return (int) Helper::get_string_between($video->sd, 'validto=', '&');
                    })
                    ->values()
                    ->slice(0, 1);
        echo "most outdate youjizz video<br>";
        foreach ($videos as $video) {
            $id = $video->id;
            $time = Helper::get_string_between($video->sd, 'validto=', '&');
            echo "ID#{$id} outdate on {$time}<br>";
        }
        echo "<br>";

        $almost = [];
        $base = Carbon::now()->addHours(4)->timestamp;
        $now = Carbon::now()->timestamp;
        $videos = Video::where('foreign_sd', 'ilike', '%"youjizz"%')->orderBy('id', 'asc')->select('id', 'title', 'sd', 'foreign_sd', 'created_at')->get();
        foreach ($videos as $video) {
            $time = Helper::get_string_between($video->sd, 'validto=', '&');
            if ($time < $base && $time < $now) {
                $almost[$video->id] = $time;
            }
        }
        echo count($almost)." youjizz videos almost outdate<br>";
        foreach ($almost as $key => $value) {
            echo "ID#{$key} outdate on {$value}<br>";
        }
        echo "<br>";

        $outdated = [];
        $base = Carbon::now()->timestamp;
        $videos = Video::where('foreign_sd', 'ilike', '%"youjizz"%')->orderBy('id', 'asc')->select('id', 'title', 'sd', 'foreign_sd', 'created_at')->get();
        foreach ($videos as $video) {
            $time = Helper::get_string_between($video->sd, 'validto=', '&');
            if ($time < $base) {
                $outdated[$video->id] = $time;
            }
        }
        echo count($outdated)." youjizz videos outdated<br>";
        foreach ($outdated as $key => $value) {
            echo "ID#{$key} outdated on {$value}<br>";
        }
        echo "<br>";

        $outdated_downloads = [];
        $base = Carbon::now()->timestamp;
        $videos = Video::where('foreign_sd', 'ilike', '%"downloadY"%')->orderBy('id', 'asc')->select('id', 'title', 'sd', 'downloads', 'foreign_sd', 'created_at')->get();
        foreach ($videos as $video) {
            $download = head($video->downloads);
            $time = Helper::get_string_between($download, 'validto=', '&');
            if ($time < $base) {
                $outdated_downloads[$video->id] = $time;
            }
        }
        echo count($outdated_downloads)." youjizz downloads outdated<br>";
        foreach ($outdated_downloads as $key => $value) {
            echo "ID#{$key} outdated on {$value}<br>";
        }
        echo "<br>";

        $outdated_downloads_sc = [];
        $base = Carbon::now()->timestamp;
        $videos = Video::where('foreign_sd', 'ilike', '%"downloadY_sc"%')->orderBy('id', 'asc')->select('id', 'title', 'sd', 'downloads_sc', 'foreign_sd', 'created_at')->get();
        foreach ($videos as $video) {
            $download_sc = head($video->downloads_sc);
            $time = Helper::get_string_between($download_sc, 'validto=', '&');
            if ($time < $base) {
                $outdated_downloads_sc[$video->id] = $time;
            }
        }
        echo count($outdated_downloads_sc)." youjizz downloads sc outdated<br>";
        foreach ($outdated_downloads_sc as $key => $value) {
            echo "ID#{$key} outdated on {$value}<br>";
        }
    }
}
