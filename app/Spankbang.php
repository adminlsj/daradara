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

            // curl
            /* $curl_connection = curl_init($video->foreign_sd['spankbang']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection); */

            // browsershot
            $html = Browsershot::url($video->foreign_sd['spankbang'])
                    ->timeout(1800)
                    ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                    ->bodyHtml();

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

            sleep(5);
        }

        Log::info('Spankbang update ended...');
    }

    public static function updateSpankbangBackup()
    {
        Log::info('Spankbang backup update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"spankbang"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->orderBy('id', 'desc')->get();

        $base = Carbon::now()->addHours(7)->timestamp;

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
                        ->timeout(1800)
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

    public static function updateSpankbangBackupReverse()
    {
        Log::info('Spankbang backup reverse update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"spankbang"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->orderBy('id', 'asc')->get();

        $base = Carbon::now()->addHours(7)->timestamp;

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
                        ->timeout(1800)
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

        Log::info('Spankbang backup reverse update ended...');
    }

    public static function updateSpankbangBackupEmergent()
    {
        Log::info('Spankbang backup emergent update started...');

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
                        ->timeout(1800)
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

        Log::info('Spankbang backup emergent update ended...');
    }

    public static function updateSpankbangErrors($number = 1, $total = 1)
    {
        Log::info('Spankbang errors update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"error"%')->where('foreign_sd', 'ilike', '%spankbang%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->orderBy('id', 'asc')->get();

        $loop = 1;
        $dividend = ceil($videos->count() / $total);
        foreach ($videos as $video) {
            if ($loop >= $dividend * ($number - 1) && $loop <= $dividend * $number) {
                if (array_key_exists("error", $video->foreign_sd) && strpos($video->foreign_sd["error"], 'spankbang') !== false ) {
                    $pass = false;
                    $sd = '';
                    $source = '';
                    $qualities = [];

                    // curl connection
                    /* $curl_connection = curl_init($video->foreign_sd['error']);
                    curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                    curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                    $html = curl_exec($curl_connection);
                    curl_close($curl_connection); */

                    // browsershot
                    $html = Browsershot::url($video->foreign_sd['error'])
                        ->timeout(1800)
                        ->disableImages()
                        ->useCookies(['_gid' => 'GA1.2.1098535915.1635852402'], '.spankbang.com')
                        ->useCookies(['postgen_interstitial_v4' => '1'], 'spankbang.com')
                        ->useCookies(['_ga' => 'GA1.2.1163545612.1635852402'], '.spankbang.com')
                        ->useCookies(['sb_session' => 'eyJfcGVybWFuZW50Ijp0cnVlLCJjb3VudHJ5IjoiU0ciLCJlZGl0aW9uIjoic2cifQ.YYEgfw.wS5z_ePr8DkhPpmXNXMz3MJdHbg'], '.spankbang.com')
                        ->useCookies(['ana_vid' => '94db8a41f82c9baa57fa2ca76872badc2a74a8f1763b96b06855c8773c639538'], '.spankbang.com')
                        ->useCookies(['ana_sid' => '94db8a41f82c9baa57fa2ca76872badc2a74a8f1763b96b06855c8773c639538'], '.spankbang.com')
                        ->useCookies(['__cf_bm' => 'drUIgf7TDv9R54ckO6KVruTJkhdt6LL72ioS4PqIMF8-1635852401-0-Aa7ylJ6cFhEOAYG0mIg0WNdypYAtGOhA+BF5GRFLdnDo+Mf2tEYSA6227IasnfHNkcPRomYZSf4eHjo4Iy0EYO12ZNeqeKUmgUpha+4Ov88N2eUrIhxK+MIGLdc1S9KAbdw9nMXy7QDpJO9nUB5bnW9CvjfxLh3XO7gzpxyDeJE1'], '.spankbang.com')
                        ->useCookies(['backend_version' => 'master'], '.spankbang.com')
                        ->useCookies(['warn_modal' => '0'], '.spankbang.com')
                        ->setOption('args', ['--disable-web-security'])
                        ->setOption('args', '--lang=en-GB')
                        ->userAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.54 Safari/537.36')
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

                        $temp = $video->foreign_sd;
                        $temp['spankbang'] = $video->foreign_sd['error'];
                        unset($temp['error']);
                        $video->foreign_sd = $temp;
                        $video->sd = reset($qualities);
                        $video->qualities = $qualities;
                        $video->outsource = false;
                        $video->save();

                    } else {
                        Log::info('Spankbang errors update ID#'.$video->id.' failed...');
                        Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Spankbang update failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                    }

                    sleep(5);
                }
            }
            $loop++;
        }

        Log::info('Spankbang errors update ended...');
    }

    public static function checkSpankbangOutdate()
    {
        $items = 0;
        $base = Carbon::now()->addHours(7)->timestamp;
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

    public static function checkSpankbangOutdateEmergent()
    {
        $items = 0;
        $base = Carbon::now()->addHours(4)->timestamp;
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
        $base = Carbon::now()->addHours(8)->timestamp;
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
