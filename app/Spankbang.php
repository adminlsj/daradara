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
    public static function updateSpankbang($number = 1, $total = 1)
    {
        Log::info('Spankbang update started...');

        $videos = Video::where('foreign_sd', 'like', '%"spankbang"%')
                    ->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')
                    ->orderBy('id', 'asc')
                    ->get()
                    ->split($total)[$number - 1]
                    ->sortBy(function($video){
                        return (int) Helper::get_string_between($video->sd, ',', '&m=');
                    })
                    ->values()
                    ->all();

        foreach ($videos as $video) {
            $html = Spankbang::getBrowsershotHtml($video->foreign_sd['spankbang']);
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
                Log::info('Spankbang update ID#'.$video->id.' success...');

            } else {
                Log::info('Spankbang update ID#'.$video->id.' failed...');
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master ('.gethostname().')', 'Spankbang update failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                $temp = $video->foreign_sd;
                $temp['error'] = $video->foreign_sd['spankbang'];
                unset($temp['spankbang']);
                $video->foreign_sd = $temp;
                $video->save();
            }
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

                $html = Spankbang::getBrowsershotHtml($video->foreign_sd['spankbang']);
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

                $html = Spankbang::getBrowsershotHtml($video->foreign_sd['spankbang']);
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

        $videos = Video::where('foreign_sd', 'ilike', '%"spankbang"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->orderBy('id', 'asc')->get();

        $base = Carbon::now()->addHours(4)->timestamp;

        foreach ($videos as $video) {
            $time = Helper::get_string_between($video->sd, ',', '&m=');
            if ($time < $base) {
                $pass = false;
                $sd = '';
                $source = '';
                $qualities = [];

                $html = Spankbang::getBrowsershotHtml($video->foreign_sd['spankbang']);
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

    public static function updateSpankbangBackupEmergentReverse()
    {
        Log::info('Spankbang backup emergent reverse update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"spankbang"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->orderBy('id', 'desc')->get();

        $base = Carbon::now()->addHours(4)->timestamp;

        foreach ($videos as $video) {
            $time = Helper::get_string_between($video->sd, ',', '&m=');
            if ($time < $base) {
                $pass = false;
                $sd = '';
                $source = '';
                $qualities = [];

                $html = Spankbang::getBrowsershotHtml($video->foreign_sd['spankbang']);
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

        Log::info('Spankbang backup emergent reverse update ended...');
    }

    public static function updateSpankbangBackupEmergentViews()
    {
        Log::info('Spankbang backup emergent views update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"spankbang"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->orderBy('current_views', 'desc')->get();

        $base = Carbon::now()->addHours(4)->timestamp;

        foreach ($videos as $video) {
            $time = Helper::get_string_between($video->sd, ',', '&m=');
            if ($time < $base) {
                $pass = false;
                $sd = '';
                $source = '';
                $qualities = [];

                $html = Spankbang::getBrowsershotHtml($video->foreign_sd['spankbang']);
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

        Log::info('Spankbang backup emergent views update ended...');
    }

    public static function updateSpankbangBackupEmergentRandom()
    {
        Log::info('Spankbang backup emergent random update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"spankbang"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->inRandomOrder()->get();

        $base = Carbon::now()->addHours(4)->timestamp;

        foreach ($videos as $video) {
            $time = Helper::get_string_between($video->sd, ',', '&m=');
            if ($time < $base) {
                $pass = false;
                $sd = '';
                $source = '';
                $qualities = [];

                $html = Spankbang::getBrowsershotHtml($video->foreign_sd['spankbang']);
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

        Log::info('Spankbang backup emergent random update ended...');
    }

    public static function updateSpankbangErrors()
    {
        Log::info('Spankbang errors update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"error"%')->where('foreign_sd', 'ilike', '%spankbang%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->orderBy('id', 'asc')->get();

        foreach ($videos as $video) {
            if (array_key_exists("error", $video->foreign_sd) && strpos($video->foreign_sd["error"], 'spankbang') !== false ) {
                $pass = false;
                $sd = '';
                $source = '';
                $qualities = [];

                $html = Spankbang::getBrowsershotHtml($video->foreign_sd['error']);
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

    public static function getBrowsershotHtml(String $url)
    {
        return Browsershot::url($url)
                ->timeout(50)
                ->disableImages()
                ->userAgent(Spankbang::$userAgents[array_rand(Spankbang::$userAgents)])
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
                ->bodyHtml();
    }

    public static $userAgents = [
        'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36 OPR/80.0.4170.48 (Edition Yx GX)',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.81',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36/3hhOU1r2-44',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.48 CitizenFX/1.0.0.4919 Safari/537.36',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.54 Safari/537.36 Edg/95.0.1020.40/zYwE5JPq-31',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:94.0) Gecko/20100101 Firefox/94.0/iwL59ud3-10',
        'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/7.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; Tablet PC 2.0; .NET CLR 1.1.4322)',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.27 Safari/537.36 Edg/96.0.1054.8',
        'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/7.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; Tablet PC 2.0; .NET CLR 1.1.4322; .NET4.0C; .NET4.0E)',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:93.0) Gecko/20100101 Firefox/93.0/rQH3oIHH-24'
    ];
}
