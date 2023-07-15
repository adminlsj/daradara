<?php

namespace App;

use Mail;
use App\Video;
use App\Helper;
use Carbon\Carbon;
use App\Mail\UserReport;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;
use App\Spankbang;
use Image;
use SteelyWing\Chinese\Chinese;

class Jav
{
    public static function uploadHscangku()
    {
        Log::info('Hscangku upload started...');

        $chinese = new Chinese();
        $id = Video::whereIn('genre', Video::$genre_jav)->orderBy('id', 'desc')->first()->id + 1;
        for ($i = 1; $i <= 3; $i++) { 
            $base = "http://515hsck.cc";
            $page_url = "{$base}/vodtype/9-{$i}.html";

            $timeout = 20;
            $page_html = Browsershot::url($page_url)
                ->timeout($timeout)
                ->ignoreHttpsErrors()
                ->disableImages()
                ->setExtraHttpHeaders(['Cookie' => '2eea60697cce6da2aeac2a6e147edd8c=f8ec670e60ba02a346b7646ce325ea38; Hm_lvt_9c69de51657cb6e2da4f620629691e94=1689093779; Hm_lpvt_9c69de51657cb6e2da4f620629691e94=1689093779; c0eb604e939747b7928695b2431c09a2=c519d27cdf1f2d87d6f95321d939a59d'])
                ->setExtraHttpHeaders(['Host' => str_replace('http://', '', $base)])
                ->setExtraHttpHeaders(['Referer' => $base])
                ->setOption('args', ['--disable-web-security'])
                ->userAgent(Spankbang::$userAgents[array_rand(Spankbang::$userAgents)])
                ->bodyHtml();

            $page_links_raw = explode('href="/vodplay', $page_html);
            array_shift($page_links_raw);
            $page_links = [];
            foreach ($page_links_raw as $page_link_raw) {
                $title = $chinese->to(Chinese::ZH_HANT, Helper::get_string_between($page_link_raw, 'title="', '"'));
                $page_link_raw = Helper::get_string_between($page_link_raw, '/', '"');
                if (!array_key_exists($page_link_raw, $page_links)) {
                    $page_links[$page_link_raw] = $title;
                }
            }
            foreach ($page_links as $hscangku_link => $title) {
                $original_link = "/vodplay/{$hscangku_link}";
                // $hscangku_link = "{$base}/vodplay/{$hscangku_link}";
                if (!Video::where('foreign_sd', 'ilike', '%'.$original_link.'%')->exists()) {
                    /* $hscangku_html = Browsershot::url($hscangku_link)
                        ->timeout($timeout)
                        ->ignoreHttpsErrors()
                        ->disableImages()
                        ->setExtraHttpHeaders(['Cookie' => '958b5d3d17412f7fbb21304527cba94f=a9258058d2afa28c4f737d782eb5cbd5; Hm_lvt_9c69de51657cb6e2da4f620629691e94=1689056890; Hm_lpvt_9c69de51657cb6e2da4f620629691e94=1689056890; cb3f8eeef124d1b64215702a6c508b31=0a737054063e1d2de784ef706312b3b4'])
                        ->setExtraHttpHeaders(['Referer' => $base])
                        ->setOption('args', ['--disable-web-security'])
                        ->userAgent(Spankbang::$userAgents[array_rand(Spankbang::$userAgents)])
                        ->bodyHtml();

                    $title = trim(Helper::get_string_between($hscangku_html, 'name="description" content="', '剧情:"'));
                    $title = $chinese->to(Chinese::ZH_HANT, $title);
                    $sd = 'https:'.str_replace('\\', '', Helper::get_string_between($hscangku_html, '"url":"https:', '"')); */

                    $imgur = "https://i.imgur.com/Ku2VhgD.jpg";
                    $cover = "https://i.imgur.com/E6mSQA2.jpg";
                    $foreign_sd = ['cover' => Helper::get_string_between($cover, 'https://i.imgur.com/', '.'), 'thumbnail' => Helper::get_string_between($imgur, 'https://i.imgur.com/', '.'), 'hscangku' => $original_link];
                    $video = Video::create([
                        'id' => $id,
                        'user_id' => 1,
                        'playlist_id' => 1,
                        'title' => $title,
                        'translations' => ['JP' => $title],
                        'caption' => '',
                        'sd' => '',
                        'imgur' => Helper::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                        'tags' => '中文字幕',
                        'tags_array' => ['中文字幕' => 100],
                        'artist' => 'artist',
                        'genre' => '日本AV',
                        'views' => 0,
                        'outsource' => false,
                        'created_at' => '2000-01-01 00:00:00',
                        'uploaded_at' => '2000-01-01 00:00:00',
                        'foreign_sd' => $foreign_sd,
                        'cover' => 'https://i.imgur.com/E6mSQA2.jpg',
                        'uncover' => true,
                    ]);

                    $id++;

                    Log::info('Hscangku update ID#'.$video->id.' success...');
                    sleep(10);
                }
            }
        }

        Log::info('Hscangku upload ended...');
    }

    public static function updateEmptySd($total = 1, $number = 1)
    {
        Log::info('Empty sd update started...');

        $base = "http://515hsck.cc";
        $videos = Video::where('foreign_sd', 'like', '%"hscangku"%')
                    ->where('sd', '')
                    ->orderBy('id', 'asc')
                    ->get()
                    ->split($total)[$number - 1]
                    ->values()
                    ->slice(0, 3);;

        foreach ($videos as $video) {
            $hscangku_html = Browsershot::url("{$base}{$video->foreign_sd['hscangku']}")
                ->timeout(20)
                ->ignoreHttpsErrors()
                ->disableImages()
                ->disableJavascript()
                ->setExtraHttpHeaders(['Cookie' => '958b5d3d17412f7fbb21304527cba94f=a9258058d2afa28c4f737d782eb5cbd5; Hm_lvt_9c69de51657cb6e2da4f620629691e94=1689056890; Hm_lpvt_9c69de51657cb6e2da4f620629691e94=1689056890; cb3f8eeef124d1b64215702a6c508b31=0a737054063e1d2de784ef706312b3b4'])
                ->setExtraHttpHeaders(['Referer' => $base])
                ->setOption('args', ['--disable-web-security'])
                ->userAgent(Spankbang::$userAgents[array_rand(Spankbang::$userAgents)])
                ->bodyHtml();

            $sd = 'https:'.str_replace('\\', '', Helper::get_string_between($hscangku_html, '"url":"https:', '"'));
            if ($sd != '' && $sd != null && $sd != 'https:') {
                $video->sd = $sd;
                $video->save();
                Log::info('Empty sd update ID#'.$video->id.' success...');

            } else {
                Log::info('Empty sd update ID#'.$video->id.' failed...');
            }

            if ($videos->last() != $video) {
                sleep(10);
            }
        }

        Log::info('Empty sd update ended...');
    }

    public static function updateWithMissav($total = 1, $number = 1)
    {
        Log::info('Missav update started...');

        $videos = Video::where('id', '>=', 48445)
                    ->where('genre', '日本AV')
                    ->where('created_at', '2000-01-01 00:00:00')
                    ->where('foreign_sd', 'not like', '%"missav"%')
                    ->orderBy('id', 'asc')
                    ->get()
                    ->split($total)[$number - 1]
                    ->values()
                    ->slice(0, 3);

        foreach ($videos as $video) {
            $missav_link = 'https://missav.com/'.explode(' ', $video->title)[0];
            $missav_html = Browsershot::url($missav_link)
                ->timeout(20)
                ->setExtraHttpHeaders(['Referer' => 'https://missav.com/'])
                ->userAgent(Spankbang::$userAgents[array_rand(Spankbang::$userAgents)])
                ->bodyHtml();

            if (strpos($missav_html, "找不到頁面") !== false) {
                $temp = $video->foreign_sd;
                $temp['missav'] = '404';
                $video->foreign_sd = $temp;
                $video->save();

                Log::info('Missav update ID#'.$video->id.' failed...');

            } else {
                $downloads = 'https://rapidgator.net/file/'.Helper::get_string_between($missav_html, 'https://rapidgator.net/file/', '"');
                $created_at = preg_replace('/\s+/', '', explode('>', Helper::get_string_between($missav_html, '發行日期:</span>', '</span>'))[1]).' '.Carbon::now()->toTimeString();
                $created_at = Carbon::parse($created_at);
                $code = preg_replace('/\s+/', '', explode('>', Helper::get_string_between($missav_html, '番號:</span>', '</span>'))[1]);
                $title_jp = $code.' '.trim(explode('>', Helper::get_string_between($missav_html, '標題:</span>', '</span>'))[1]);
                $characters = Helper::get_string_between($missav_html, '女優:</span>', '</div>');
                $characters = explode(',', $characters);
                foreach ($characters as &$character) {
                    $character = Helper::get_string_between($character, '>', '<');
                }
                $brand = Helper::get_string_between($missav_html, '發行商:</span>', '</div>');
                $brand = trim(Helper::get_string_between($brand, '>', '<'));
                if (strpos($brand, "Moody's") !== false) {
                    $brand = 'Moodyz';
                }
                if ($video->caption == '' || $video->caption == null) {
                    $caption = trim(Helper::get_string_between($missav_html, 'line-clamp-2">', '</div>'));
                    $video->caption = $caption;
                }

                $video->translations = ['JP' => $title_jp];
                $video->downloads = ['720' => $downloads];
                $video->artist = $brand;
                $video->created_at = $created_at;
                $video->uploaded_at = $created_at;

                $temp = $video->foreign_sd;
                $temp['characters'] = implode(',', $characters);
                $temp['missav'] = $missav_link;
                $temp['poster'] = trim(Helper::get_string_between($missav_html, 'property="og:image" content="', '"'));
                $video->foreign_sd = $temp;
                $video->save();

                Log::info('Missav update ID#'.$video->id.' success...');
            }

            if ($videos->last() != $video) {
                sleep(10);
            }
        }

        Log::info('Missav update ended...');
    }

    public static function updateMissavImgur($total = 1, $number = 1)
    {
        Log::info('Imgur update started...');

        $videos = Video::where('foreign_sd', 'like', '%"missav"%')
                    ->where('foreign_sd', 'like', '%"poster"%')
                    ->where('imgur', 'Ku2VhgD')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->split($total)[$number - 1]
                    ->values()
                    ->slice(0, 3);

        foreach ($videos as $video) {
            $imgur = '';
            $cover = '';
            $imgur_url = $video->foreign_sd['poster'];
            $image = Image::make($imgur_url);
            $image = $image->fit(2880, 1620, function ($constraint) {}, "top");
            $image = $image->stream();
            $pvars = array('image' => base64_encode($image));
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '5b63b1c883ddb72'));
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
            $out = curl_exec($curl);
            curl_close ($curl);
            $pms = json_decode($out, true);
            $imgur = $pms['data']['link'];

            $image = Image::make($imgur_url);
            $image = $image->fit(268, 394, function ($constraint) {}, "right");
            $image = $image->stream();
            $pvars = array('image' => base64_encode($image));
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '5b63b1c883ddb72'));
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
            $out = curl_exec($curl);
            curl_close ($curl);
            $pms = json_decode($out, true);
            $cover = $pms['data']['link'];

            $video->imgur = Helper::get_string_between($imgur, 'https://i.imgur.com/', '.');
            $temp = $video->foreign_sd;
            $temp['cover'] = Helper::get_string_between($cover, 'https://i.imgur.com/', '.');
            $temp['thumbnail'] = Helper::get_string_between($imgur, 'https://i.imgur.com/', '.');
            unset($temp['poster']);
            $video->foreign_sd = $temp;
            $video->save();

            Log::info('Imgur update ID#'.$video->id.' success...');

            if ($videos->last() != $video) {
                sleep(10);
            }
        }

        Log::info('Imgur update ended...');
    }
}