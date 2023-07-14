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

class Jav
{
    public static function updateEmptySd($total = 1, $number = 1)
    {
        Log::info('Empty sd update started...');

        $base = "http://513hsck.cc";
        $videos = Video::where('foreign_sd', 'like', '%"hscangku"%')
                    ->where('sd', null)
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

            $imgur = '';
            $cover = '';
            $imgur_url = trim(Helper::get_string_between($missav_html, 'property="og:image" content="', '"'));
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

            $video->translations = ['JP' => $title_jp];
            $video->downloads = ['720' => $downloads];
            $video->artist = $brand;
            $video->created_at = $created_at;
            $video->uploaded_at = $created_at;
            $video->imgur = Helper::get_string_between($imgur, 'https://i.imgur.com/', '.');

            $temp = $video->foreign_sd;
            $temp['characters'] = implode(',', $characters);
            $temp['missav'] = $missav_link;
            $temp['cover'] = Helper::get_string_between($cover, 'https://i.imgur.com/', '.');
            $temp['thumbnail'] = Helper::get_string_between($imgur, 'https://i.imgur.com/', '.');
            $video->foreign_sd = $temp;
            $video->save();

            Log::info('Missav update ID#'.$video->id.' success...');

            if ($videos->last() != $video) {
                sleep(10);
            }
        }

        Log::info('Missav update ended...');
    }
}