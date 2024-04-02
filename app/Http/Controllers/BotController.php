<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\Comic;
use App\Watch;
use App\Like;
use App\Save;
use Mail;
use App\Mail\UserReport;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;
use App\Rule34;
use App\Cosplayjav;
use App\Helper;
use App\Comment;
use App\User;
use Carbon\Carbon;
use App\Spankbang;
use App\Youjizz;
use App\Motherless;
use App\Nhentai;
use Storage;
use Redirect;
use File;
use Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use SteelyWing\Chinese\Chinese;
use App\Jav;
use App\Video_temp;

class BotController extends Controller
{
    public function tempMethod(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        // Change likes
        /* $current = request('current');
        $new = request('new');
        $likes = Like::where('foreign_id', $current)->where('foreign_type', 'video')->get();
        foreach ($likes as $like) {
            $like->foreign_id = $new;
            $like->save();
        } */

        // Change saves
        $current = request('current');
        $new = request('new');
        $saves = Save::where('video_id', $current)->get();
        foreach ($saves as $save) {
            $save->video_id = $new;
            $save->save();
        }

        // Update missav cover
        /* $videos = Video::where('cover', 'like', '%i.rotriza.com%')->get();
        foreach ($videos as $video) {
            $temp = $video->foreign_sd;
            $temp['poster'] = str_replace('i.rotriza.com', 'eightcha.com', $temp['poster']);
            $video->foreign_sd = $temp;
            $video->cover = str_replace('i.rotriza.com', 'eightcha.com', $video->cover);
            $video->save();
        } */

        // Update outdated hscangku poster
        /* $videos = Video::whereIn('genre', Video::$genre_jav)->where('foreign_sd', 'like', '%\666549.xyz%')->get();
        foreach ($videos as $video) {
            $temp = $video->foreign_sd;
            $temp["poster"] = str_replace('666549.xyz', '666532.xyz', $temp["poster"]);
            $video->foreign_sd = $temp;
            $video->cover = str_replace('666549.xyz', '666532.xyz', $video->cover);
            $video->save();
        } */

        /* $videos = Video::whereIn('genre', ['裏番', '泡麵番', 'Motion Anime', '3D動畫', '同人作品', 'Cosplay', '新番預告'])->where('cover', 'like', '%https://img4.qy0.ru%')->get();
        foreach ($videos as $video) {
            $filename = explode('.jpg', substr($video->cover, strrpos($video->cover, '/') + 1))[0].'.jpg';
            $url = 'vdownload.hembed.com';
            $expiration = time() + 43200;
            $token = 'xVEO8rLVgGkUBEBg';
            $source = '/image/cover/'.$filename;
            $video->cover = Video::getSignedUrlParameter($url, $source, $token, $expiration);
            $video->save();
        } */

        $filename = '91774.jpg';
        $url = 'vdownload.hembed.com';
        $expiration = time() + 2629743;
        $token = 'xVEO8rLVgGkUBEBg';
        $source = '/image/cover/'.$filename;
        return Video::getSignedUrlParameter($url, $source, $token, $expiration);

        /* $id = 84803;
        $huge = $id.'h.jpg';
        $large = $id.'l.jpg';
        $poster = "https://cdn82.akamai-content-network.com/dldss-220/cover.jpg?class=normal";

        Image::make($poster)
                    ->fit(1024, 576, function ($constraint) {}, "top")
                    ->save("thumbnail/{$huge}", 80);

        Image::make($poster)
            ->fit(640, 360, function ($constraint) {}, "top")
            ->save("thumbnail/{$large}", 80); */

        /* $ids = [];
        $videos = Video::where('genre', '國產素人')->where('cover', 'https://i.imgur.com/E6mSQA2.jpg')->where('created_at', '<=', '2022-11-26 06:19:40')->where('created_at', '>=', '2022-09-28 15:11:14')->orderBy('created_at', 'desc')->get();
        foreach ($videos as $video) {
            $url = 'https://i.imgur.com/'.$video->imgur.'.jpg';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, '60'); // in seconds
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($ch);
            if (curl_getinfo($ch)['url'] != $url){
                $video->imgur = 'Ku2VhgD';
                $video->save();
                array_push($ids, $video->id);
            }
        }
        return $ids; */

        /* Log::info('Playlist update started...');

        $artist = $request->artist;
        $user_id = $request->id;
        $videos = Video::where('artist', $artist)->where('user_id', 1)->where('foreign_sd', 'like', '%"missav"%')->orderBy('title', 'asc')->get();
        foreach ($videos as $video) {
            $video->user_id = $user_id;
            $missav_html = Browsershot::url($video->foreign_sd['missav'])
                ->timeout(20)
                ->setExtraHttpHeaders(['Referer' => 'https://missav.com/'])
                ->userAgent(Spankbang::$userAgents[array_rand(Spankbang::$userAgents)])
                ->bodyHtml();

            if (strpos($missav_html, "系列:</span>") !== false) {
                $title = trim(explode('>', Helper::get_string_between($missav_html, '系列:</span>', '</a>'))[1]);
                if ($watch = Watch::where('title', $title)->first()) {
                    $video->playlist_id = $watch->id;
                } else {
                    $watch = Watch::create([
                        'user_id' => $user_id,
                        'title' => $title,
                        'description' => $title,
                    ]);
                    $video->playlist_id = $watch->id;
                }
                $video->save();
                Log::info('Playlist update ID#'.$video->id.' success...');

            } elseif (strpos($missav_html, "標籤:</span>") !== false) {
                $tag = trim(explode('>', Helper::get_string_between($missav_html, '標籤:</span>', '</a>'))[1]);
                if ($tag_watch = Watch::where('title', $tag)->first()) {
                    $video->playlist_id = $tag_watch->id;
                } else {
                    $tag_watch = Watch::create([
                        'user_id' => $user_id,
                        'title' => $tag,
                        'description' => $tag,
                    ]);
                    $video->playlist_id = $tag_watch->id;
                }
                $video->save();
                Log::info('Playlist update ID#'.$video->id.' success...');

            } else {
                Log::info('Playlist update ID#'.$video->id.' failed...');
            }
        }

        Log::info('Playlist update ended...'); */

        /* Log::info('Playlist update started...');

        // $artist = 'Glory Quest';
        $code = "GETS-";
        $user_id = 547865;
        $default_watch_id = 7255;
        $videos = Video::where('user_id', 1)->where('title', 'like', "{$code}%")->where('foreign_sd', 'like', '%"missav"%')->orderBy('title', 'asc')->get();
        foreach ($videos as $video) {
            $video->user_id = $user_id;
            // $video->artist = $artist;
            $missav_html = Browsershot::url($video->foreign_sd['missav'])
                ->timeout(20)
                ->setExtraHttpHeaders(['Referer' => 'https://missav.com/'])
                ->userAgent(Spankbang::$userAgents[array_rand(Spankbang::$userAgents)])
                ->bodyHtml();

            if (strpos($missav_html, "系列:</span>") !== false) {
                $title = trim(explode('>', Helper::get_string_between($missav_html, '系列:</span>', '</a>'))[1]);
                if ($watch = Watch::where('title', $title)->first()) {
                    $video->playlist_id = $watch->id;
                } else {
                    $watch = Watch::create([
                        'user_id' => $user_id,
                        'title' => $title,
                        'description' => $title,
                    ]);
                    $video->playlist_id = $watch->id;
                }

            } else {
                $video->playlist_id = $default_watch_id;
            }

            $video->save();

            Log::info('Playlist update ID#'.$video->id.' success...');
        }

        Log::info('Playlist update ended...'); */

        /* $base = "http://513hsck.cc";
        $videos = Video::where('foreign_sd', 'like', '%"hscangku"%')
                    ->where('sd', '')
                    ->orderBy('id', 'asc')
                    ->get()
                    ->split(10)[0]
                    ->values();

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

            $video->sd = 'https:'.str_replace('\\', '', Helper::get_string_between($hscangku_html, '"url":"https:', '"'));
            $video->save();
        } */

        // Upload hscangku
        /* $chinese = new Chinese();
        $id = Video::where('genre', '日本AV')->orderBy('id', 'desc')->first()->id + 1;
        $count = Video::where('id', '>=', 48445)->where('genre', '日本AV')->get()->count();
        $page = floor($count / 40) + 1;
        for ($i = $page; $i <= 423; $i++) { 
            $base = "http://737hsck.cc";
            $page_url = "{$base}/vodtype/9-{$i}.html";

            $timeout = 30;
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
                $hscangku_link = "{$base}/vodplay/{$hscangku_link}";
                if (!Video::where('foreign_sd', 'ilike', '%'.$original_link.'%')->exists()) {
                    $hscangku_html = Browsershot::url($hscangku_link)
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
                    $sd = 'https:'.str_replace('\\', '', Helper::get_string_between($hscangku_html, '"url":"https:', '"'));

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
                }
            }
        } */

        /* $videos = Video::where('id', '>=', 40001)->where('user_id', 1)->where('playlist_id', 3903)->orderBy('id', 'asc')->limit(300)->get();
        foreach ($videos as $video) {
            $video->playlist_id = 4324;
            $video->save();
        } */

        // Check repeats
        /* $videos = Video::whereIn('genre', Video::$genre_jav)->get();
        $codes = [];
        $repeats = [];
        foreach ($videos as $video) {
            $code = explode(' ', $video->title)[0];
            if (in_array($code, $codes)) {
                array_push($repeats, $code);
            } else {
                array_push($codes, $code);
            }
        }
        return $repeats; */

        /* foreach ($repeats as $repeat) {
            if (Video::where('title', 'like', $repeat.' %')->where('foreign_sd', 'like', '%"hscangku"%')->count() == 2) {

                $first = Video::where('title', 'like', $repeat.' %')->where('foreign_sd', 'like', '%"hscangku"%')->orderBy('id', 'asc')->first();
                $second = Video::where('title', 'like', $repeat.' %')->where('foreign_sd', 'like', '%"hscangku"%')->orderBy('id', 'asc')->skip(1)->first();

                $temp = $second->foreign_sd;
                $temp["backup"] = $first->sd;
                $temp["hscangku2"] = $first->foreign_sd["hscangku"];
                $second->foreign_sd = $temp;
                $second->save();
            }
        } */

        /* $videos = Video::where('foreign_sd', 'like', '%"hscangku"%')->where('foreign_sd', 'not like', '%"avbebe"%')->get();
        foreach ($videos as $video) {
            $code = explode(' ', $video->title)[0];
            if ($avbebe = Video::where('foreign_sd', 'not like', '%"hscangku"%')->where('foreign_sd', 'like', '%"avbebe"%')->where('sd', 'like', '%n2020.com%')->where('title', 'like', $code.' %')->first()) {
                if ($video->sd == '' || $video->sd == $avbebe->sd) {
                    $temp = $avbebe->foreign_sd;
                    $temp["hscangku"] = $video->foreign_sd["hscangku"];
                    $avbebe->foreign_sd = $temp;
                    $avbebe->save();
                    $video->delete();
                }
            }
        } */

        // Remove empty characters
        /* $videos = Video::where('foreign_sd', 'like', '%"characters": ""%')->get();
        foreach ($videos as $video) {
            $temp = $video->foreign_sd;
            unset($temp['characters']);
            $video->foreign_sd = $temp;
            $video->save();
        } */

        // Check sd playable
        /* $videos = Video::where('id', '>=', 46127)->where('genre', '素人業餘')->where('sd', 'like', '%langyouplay.com%')->get();
        foreach ($videos as $video) {
            $curl_connection = curl_init($video->sd);
            curl_setopt($curl_connection, CURLOPT_NOBODY, true);
            curl_setopt($curl_connection, CURLOPT_HEADER, true);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($curl_connection);
            $httpcode = curl_getinfo($curl_connection, CURLINFO_HTTP_CODE);
            curl_close($curl_connection);

            if ($httpcode != '200') {
                echo "ID#{$video->id} <a href='/jav/watch?v={$video->id}' target='_blank'>watch</a> {$video->title}<br>";
            }
        } */

        // Update jable tags
        /* $videos = Video::whereIn('genre', Video::$genre_jav)->where('foreign_sd', 'not like', '%"jable"%')->orderBy('id', 'asc')->where('tags_array', '{"中文字幕":100}')->get();
        foreach ($videos as $video) {
            $code = strtolower(trim(explode(' ', $video->title)[0]));
            $jable_url = "https://jable.tv/videos/{$code}/";
            $jable_html = Browsershot::url($jable_url)
                ->timeout(20)
                ->setExtraHttpHeaders(['Referer' => 'https://jable.tv/'])
                ->userAgent(Spankbang::$userAgents[array_rand(Spankbang::$userAgents)])
                ->bodyHtml();

            $title = Helper::get_string_between($jable_html, '<title>', '</title>');
            if ($title != '404 頁面丟失 - Jable.TV | 免費高清AV在線看 | J片 AV看到飽') {
                $tags_html = str_replace('>•</span>', '', Helper::get_string_between($jable_html, '<h5 class="tags h6-md">', '</h5>'));
                $tags_collection = explode('/a>', $tags_html);
                array_pop($tags_collection);
                $tags_array = [];
                foreach ($tags_collection as &$tag) {
                    $tag = Helper::get_string_between($tag, '>', '<');
                    if ($tag != '主奴調教' && $tag != '凌辱強暴' && $tag != '制服誘惑' && $tag != '角色劇情' && $tag != '盜攝偷拍' && $tag != '無碼解放' && $tag != '多P群交' && $tag != '絲襪美腿') {
                        $tags_array[$tag] = 100;
                    }
                }
                $video->tags = implode(' ', array_keys($tags_array));
                $video->tags_array = $tags_array;
                $temp = $video->foreign_sd;
                $temp['jable'] = $jable_url;
                $video->foreign_sd = $temp;
                $video->save();

            } else {
                $temp = $video->foreign_sd;
                $temp['jable'] = '404';
                $video->foreign_sd = $temp;
                $video->save();
            }
        } */

        // Update with MissAV
        /* $videos = Video::where('id', '>=', 48445)->where('genre', '日本AV')->where('created_at', '2000-01-01 00:00:00')->orderBy('id', 'asc')->get();
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
        } */

        // Update Avbebe caption
        /* $videos = Video::where('id', '>=', 46127)->where('genre', '素人業餘')->where('caption', '')->orderBy('id', 'asc')->get();
        foreach ($videos as $video) {
            // $curl_connection = curl_init('https://avbebe.com/archives/151828');
            $curl_connection = curl_init($video->foreign_sd['avbebe']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $avbebe_html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $caption = trim(Helper::get_string_between($avbebe_html, '</p><br/>', '</p>'));
            if (!empty($caption) && $caption != 'tg：@avbebe') {
                $video->caption = $caption;
                $video->save();
            }

            if (strpos($avbebe_html, 'aria-labelledby="elementor-tab-title-') !== false) {
                $data = explode('aria-labelledby="elementor-tab-title-', $avbebe_html)[1];
                $caption = Helper::get_string_between($data, '<p>', '</p>');
                if (!empty($caption) && $caption != 'tg：@avbebe') {
                    $video->caption = preg_replace('/\s+/', '', $caption);
                    $video->save();
                }
            }
        } */

        // Update Avbebe sd
        /* $videos = Video::where('id', '>=', 47579)->where('genre', '高清無碼')->where('sd', '')->get();
        foreach ($videos as $video) {
            $curl_connection = curl_init($video->foreign_sd['avbebe']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $avbebe_html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $raw = Helper::get_string_between($avbebe_html, 'data-item="', '"');
            $data = Helper::get_string_between($raw, 'src&quot;:&quot;', '&quot;');
            $sd = str_replace('#', '', str_replace('\\', '', $data));

            $video->sd = $sd;
            $video->save();
        } */

        // Upload Avbebe JAV
        /* $id = 47579;
        for ($i = 1; $i <= 37; $i++) { 
            $page_url = "https://avbebe.com/archives/category/%e7%b6%9c%e5%90%88av/%e7%b6%9c%e5%90%88av-%e7%84%a1%e7%a2%bc";
            if ($i > 1) {
                $page_url = "https://avbebe.com/archives/category/%e7%b6%9c%e5%90%88av/%e7%b6%9c%e5%90%88av-%e7%84%a1%e7%a2%bc/page/{$i}";
            }

            $curl_connection = curl_init($page_url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $page_html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $page_links = explode('<h3 class="jeg_post_title">', $page_html);
            array_shift($page_links);
            foreach ($page_links as $avbebe_link) {
                $avbebe_link = Helper::get_string_between($avbebe_link, '<a href="', '"');
                if (!Video::where('foreign_sd', 'ilike', '%'.$avbebe_link.'%')->exists()) {
                    $curl_connection = curl_init($avbebe_link);
                    curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                    curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                    $avbebe_html = curl_exec($curl_connection);
                    curl_close($curl_connection);

                    $title = Helper::get_string_between($avbebe_html, '】', ' &#8211; Avbebe.com 高清H動畫♥沒有片頭廣告♥最新里番');
                    $userInteractionCount = Helper::get_string_between($avbebe_html, '"userInteractionCount":', '}}</script>');
                    $caption = Helper::get_string_between($avbebe_html, 'userInteractionCount":'.$userInteractionCount.'}}</script>', '</div>');
                    $sd = Helper::get_string_between($avbebe_html, 'type="application/x-mpegurl" src="', '"');

                    $imgur_url = preg_replace('/\s+/', '', Helper::get_string_between($avbebe_html, 'poster="', '"'));
                    $imgur_url = explode('/', $imgur_url);
                    $base = array_pop($imgur_url);
                    $imgur_url = implode('/', $imgur_url) . '/' . urlencode($base);

                    if (!empty($imgur_url) && $imgur_url != '/') {
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
                    } else {
                        $imgur = "https://i.imgur.com/Ku2VhgD.jpg";
                        $cover = "https://i.imgur.com/E6mSQA2.jpg";
                    }

                    $foreign_sd = ['cover' => Helper::get_string_between($cover, 'https://i.imgur.com/', '.'), 'thumbnail' => Helper::get_string_between($imgur, 'https://i.imgur.com/', '.'), 'avbebe' => $avbebe_link];
                    $video = Video::create([
                        'id' => $id,
                        'user_id' => 1,
                        'playlist_id' => 1,
                        'title' => $title,
                        'translations' => ['JP' => $title],
                        'caption' => preg_replace('/\s+/', '', $caption),
                        'sd' => $sd,
                        'imgur' => Helper::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                        'tags' => '中文字幕',
                        'tags_array' => ['中文字幕' => 100],
                        'artist' => 'artist',
                        'genre' => '高清無碼',
                        'views' => 0,
                        'outsource' => false,
                        'created_at' => '2000-01-01 00:00:00',
                        'uploaded_at' => '2000-01-01 00:00:00',
                        'foreign_sd' => $foreign_sd,
                        'cover' => 'https://i.imgur.com/E6mSQA2.jpg',
                        'uncover' => true,
                    ]);

                    $id++;
                }
            }
        } */

        // Updload JAV from Avbebe & Missav
        /* $id = $request->vid;
        $avbebe_link = $request->avbebe;
        $avbebe_html = Browsershot::url($avbebe_link)
                ->timeout(20)
                ->setExtraHttpHeaders(['Referer' => 'https://avbebe.com/'])
                ->userAgent(Spankbang::$userAgents[array_rand(Spankbang::$userAgents)])
                ->bodyHtml();
        $title = str_replace(' – Avbebe.com 高清H動畫♥沒有片頭廣告♥最新里番', '', str_replace('【綜合AV影片-中文AV】', '', Helper::get_string_between($avbebe_html, '<title>', '</title>')));
        $userInteractionCount = Helper::get_string_between($avbebe_html, '"userInteractionCount":', '}}</script>');
        $caption = Helper::get_string_between($avbebe_html, 'userInteractionCount":'.$userInteractionCount.'}}</script>', '</div>');
        $sd = Helper::get_string_between($avbebe_html, 'type="application/x-mpegurl" src="', '"');
        
        $imgur_url = preg_replace('/\s+/', '', Helper::get_string_between($avbebe_html, 'poster="', '"'));

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

        $missav_link = $request->missav;
        $missav_html = Browsershot::url($missav_link)
                ->timeout(20)
                ->setExtraHttpHeaders(['Referer' => 'https://missav.com/'])
                ->userAgent(Spankbang::$userAgents[array_rand(Spankbang::$userAgents)])
                ->bodyHtml();
        $downloads = 'https://rapidgator.net/file/'.Helper::get_string_between($missav_html, 'https://rapidgator.net/file/', '"');
        $created_at = preg_replace('/\s+/', '', Helper::get_string_between($missav_html, '發行日期:</span>
<span class="font-medium">', '</span>')).' '.Carbon::now()->toTimeString();
        $created_at = Carbon::parse($created_at);
        $code = preg_replace('/\s+/', '', Helper::get_string_between($missav_html, '番號:</span>
<span class="font-medium">', '</span>'));
        $title_jp = $code.' '.preg_replace('/\s+/', '', Helper::get_string_between($missav_html, '標題:</span>
<span class="font-medium">', '</span>'));
        $characters = Helper::get_string_between($missav_html, '女優:</span>', '</div>');
        $characters = explode(',', $characters);
        foreach ($characters as &$character) {
            $character = Helper::get_string_between($character, '>', '<');
        }
        $brand = preg_replace('/\s+/', '', Helper::get_string_between($missav_html, '發行商:</span>', '</div>'));
        $brand = Helper::get_string_between($brand, '>', '<');
        if (strpos($brand, "Moody's") !== false) {
            $brand = 'Moodyz';
        }

        $url = "https://i.imgur.com/Ku2VhgD.jpg";
        $tags_array = [];
        foreach (explode('|', $request->tags) as $tag) {
            $tags_array[$tag] = 10;
        }
        $foreign_sd = ['cover' => Helper::get_string_between($cover, 'https://i.imgur.com/', '.'), 'thumbnail' => Helper::get_string_between($imgur, 'https://i.imgur.com/', '.'), 'avbebe' => $avbebe_link, 'missav' => $missav_link, 'characters' => implode(',', $characters)];
        $video = Video::create([
            'id' => $id,
            'user_id' => 1,
            'playlist_id' => 1,
            'title' => $title,
            'translations' => ['JP' => $title_jp],
            'caption' => preg_replace('/\s+/', '', $caption),
            'sd' => $sd,
            'downloads' => ['720' => $downloads],
            'imgur' => Helper::get_string_between($imgur, 'https://i.imgur.com/', '.'),
            'tags' => implode(' ', explode('|', $request->tags)),
            'tags_array' => $tags_array,
            'artist' => $brand,
            'genre' => '日本AV',
            'views' => 0,
            'outsource' => false,
            'created_at' => $created_at,
            'uploaded_at' => $created_at,
            'foreign_sd' => $foreign_sd,
            'cover' => 'https://i.imgur.com/E6mSQA2.jpg',
            'uncover' => true,
        ]);

        return Redirect::route('jav.watch', ['v' => $video->id]); */

        // download missav
        /* $url = $request->get('url');
        $folder = str_replace('https://missav.com/', '', $url);

        $html = Browsershot::url($url)
                ->timeout(20)
                ->disableImages()
                ->userAgent(Spankbang::$userAgents[array_rand(Spankbang::$userAgents)])
                ->bodyHtml();
        $m3u8 = html_entity_decode(str_replace('842x480', '1280x720', Helper::get_string_between($html, 'style="" src="', '"')));
        $opts = [
            'http' => [
               'header' => [
                    "Referer: https://missav.com/"
                ]
            ]
        ];

        $m3u8 = "https://cdn152.bestjavcdn.com/bcdn_token=O6UDnAYG1loe47r3XgH2Z_wZz-Zf-BtrxRmWniSsRDs&expires=1701264649&token_path=%2Fc15e59a1-4980-49e6-a3f7-5b101e2b6431%2F/c15e59a1-4980-49e6-a3f7-5b101e2b6431/842x480/video.m3u8";

        $context = stream_context_create($opts);
        Storage::disk('local')->put("video/{$folder}/video.m3u8", file_get_contents($m3u8, false, $context));

        $content = File::get(storage_path()."/app/video/{$folder}/video.m3u8");
        $total_array = explode("video", $content);
        $total = preg_replace("/[^0-9]/", "", end($total_array));
        for ($i = 0; $i <= $total; $i++) {
            $url = explode('video', $m3u8)[0]."video{$i}.ts";
            Storage::disk('local')->put("video/{$folder}/video{$i}.ts", file_get_contents($url, false, $context));
        } */

        // Remove lesser tags
        /* $videos = Video::all();
        foreach ($videos as $video) {
            $tags_array = $video->tags_array;
            foreach ($tags_array as $key => $value) {
                if ($value < 4) {
                    unset($tags_array[$key]);
                }
            }
            $video->tags_array = $tags_array;
            $video->save();
        } */

        /* $videos = Video::where('cover', 'not like', '%imgur%')->orderBy('id', 'desc')->get();
        foreach ($videos as $video) {
            // cover
            $file_name = basename($video->cover);
            if (!file_exists(public_path('cover/'.$file_name))) {
                if (file_put_contents('cover/'.$file_name, file_get_contents($video->cover))) {
                    echo 'cover '.$file_name.' success<br>';
                } else {
                    echo 'cover '.$file_name.' failed<br>';
                }
            } else {
                echo 'cover '.$file_name.' exists<br>';
            }

            // thumbnail
            $cover = Helper::get_string_between($video->cover, '/cover/', '.jpg');

            $huge = str_replace('/cover/'.$cover, '/thumbnail/'.$video->imgur.'h', $video->cover);
            $huge_file_name = $video->imgur.'h.jpg';
            if (!file_exists('thumbnail/'.public_path($huge_file_name))) {
                if (file_put_contents('thumbnail/'.$huge_file_name, file_get_contents($huge))) {
                    echo 'thumbH '.$huge.' success<br>';
                } else {
                    echo 'thumbH '.$huge.' failed<br>';
                }
            } else {
                echo 'thumbH '.$huge.' exists<br>';
            }

            $large = str_replace('/cover/'.$cover, '/thumbnail/'.$video->imgur.'l', $video->cover);
            $large_file_name = $video->imgur.'l.jpg';
            if (!file_exists('thumbnail/'.public_path($large_file_name))) {
                if (file_put_contents('thumbnail/'.$large_file_name, file_get_contents($large))) {
                    echo 'thumbL '.$large.' success<br>';
                } else {
                    echo 'thumbL '.$large.' failed<br>';
                }
            } else {
                echo 'thumbL '.$large.' exists<br>';
            }
        } */

        /* $videos = Video::all();
        foreach ($videos as $video) {
            $searchtext = $video->title.'|'.$video->translations['JP'].'|'.implode('|', array_keys($video->tags_array)).'|'.$video->genre.'|'.$video->artist;
            $video->searchtext = mb_strtolower(preg_replace('/\s+/', '', $searchtext), 'UTF-8');
            $video->save();
        } */

        /* for ($i = 0; $i <= 157; $i++) { 
            $initial = "https://cdn1.htstreaming.com/cdn/down/cd2a7e30451a8eb993a1f4f34b293f37/Video/720p/720p_";

            if ($i < 10) {
                $url = "{$initial}00{$i}.html";
                Storage::disk('local')->put("video/00{$i}.ts", file_get_contents($url));
            } elseif ($i < 100) {
                $url = "{$initial}0{$i}.html";
                Storage::disk('local')->put("video/0{$i}.ts", file_get_contents($url));
            } elseif ($i < 1000) {
                $url = "{$initial}{$i}.html";
                Storage::disk('local')->put("video/{$i}.ts", file_get_contents($url));
            }
        } */

        /* $videos = Video::where('tags_array', 'like', '%"MaohKing"%')->get();
        foreach ($videos as $video) {
            $tags_array = $video->tags_array;
            unset($tags_array['MaohKing']);
            $tags_array['Maoh King'] = 10;
            $video->tags_array = $tags_array;
            $video->save();
        } */

        /* $videos = Video::where('tags_array', 'like', '%"劇情"%')->get();
        foreach ($videos as $video) {
            $tags_array = $video->tags_array;
            unset($tags_array['劇情']);
            $video->tags_array = $tags_array;
            $video->save();
        } */

        /* $array = [];
        for ($i=0; $i < 236; $i++) { 
            array_push($array, 'j');
        }
        return $array; */

        /* $data = "";
        $parse = explode('#EXTINF', $data);
        array_shift($parse);        
        foreach ($parse as &$item) {
            $item = str_replace('#EXT-X-ENDLIST', '', $item);
            $item = trim(explode(',', $item)[1]);
        }
        foreach ($parse as $ts) {
            $referer = "https://iqqtv.net/";
            $opts = [
                'http' => [
                   'header' => [
                        "Referer: https://iqqtv.net/"
                    ]
                ]
            ];
            $context = stream_context_create($opts);
            Storage::disk('local')->put("video/".basename($ts), file_get_contents($ts, false, $context));
        } */

        /* $tc = Storage::disk('local')->files('video/tc');
        foreach ($tc as $video) {
            $extension = explode('.', $video)[1];
            if ($extension == 'ts') {
                $number = Helper::get_string_between($video, 'video/tc/video', '.ts');
                $folder = $number % 3;
                Storage::disk('local')->move($video, "video/tc/{$folder}/p_{$number}.html");
            }
        }

        $sc = Storage::disk('local')->files('video/sc');
        foreach ($sc as $video) {
            $extension = explode('.', $video)[1];
            if ($extension == 'ts') {
                $number = Helper::get_string_between($video, 'video/sc/video', '.ts');
                $folder = $number % 3;
                Storage::disk('local')->move($video, "video/sc/{$folder}/p_{$number}.html");
            }
        } */

        /* $videos = Video::where('foreign_sd', 'like', '%"youjizz"%')->get();
        foreach ($videos as $video) {
            $array = explode('-', $video->foreign_sd["youjizz"]);
            $end = end($array);
            $id = str_replace('.html', '', $end);
            $video->sd = 'https://www.youjizz.com/videos/embed/'.$id;
            $video->outsource = true;
            $video->qualities = null;
            $video->save();
        } */

        /* $url = 'https://vdownload-1.hembed.com/12499-720p.mp4';
        return Helper::sign_hembed_url($url, env('HEMBED_TOKEN'), 43200); */

        /* for ($i = 0; $i <= 239; $i++) { 
            $vid = "c66d1ae7-171a-463f-a866-56eb05df0321";
            $folder = $i % 3;
            $url = "https://vz-e9c9f2c4-a7f.b-cdn.net/{$vid}/1920x1080/video{$i}.ts";
            Storage::disk('local')->put("video/{$folder}/p_{$i}.html", file_get_contents($url));
        } */

        /* curl -O --referer https://avbebe.com/ https://vz-e9c9f2c4-a7f.b-cdn.net/dacb9593-b19f-4617-9b57-d4790c8089d1/1920x1080/video0.ts */

        // check imgur exists
        /* echo 'Imgurs check start<br>';
        $imgurs = Video::where('cover', 'ilike', '%imgur%')->select('id', 'title', 'cover', 'imgur')->get();
        foreach ($imgurs as $video) {
            $url = 'https://i.imgur.com/'.$video->imgur.'.jpg';
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, '60'); // in seconds
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($ch);

            if (curl_getinfo($ch)['url'] != $url){
                echo 'ID#'.$video->id.' '.$video->title.'<br>';
            }
        }

        echo 'Covers check start<br>';
        $covers = Video::where('cover', 'ilike', '%imgur%')->select('id', 'title', 'cover')->get();
        foreach ($covers as $video) {
            $url = $video->cover;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, '60'); // in seconds
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($ch);

            if (curl_getinfo($ch)['url'] != $url){
                echo 'ID#'.$video->id.' '.$video->title.'<br>';
            }
        } */

        // download imgurs
        /* $videos = Video::where('cover', 'like', '%imgur%')->orderBy('id', 'desc')->select('id', 'cover', 'imgur')->get()->slice(0, 300);
        foreach ($videos as $video) {
            // cover
            $file_name = str_replace('.png', '.jpg', basename($video->cover));
            if (!file_exists(public_path('cover/'.$file_name))) {
                if (file_put_contents('cover/'.$file_name, file_get_contents($video->cover))) {
                    echo 'cover '.$file_name.' success<br>';
                } else {
                    echo 'cover '.$file_name.' failed<br>';
                }
            } else {
                echo 'cover '.$file_name.' exists<br>';
            }

            // thumbnail
            $huge = $video->imgur.'h.jpg';
            if (!file_exists('thumbnail/'.public_path($huge))) {
                if (file_put_contents('thumbnail/'.$huge, file_get_contents('https://i.imgur.com/'.$huge))) {
                    echo 'thumbH '.$huge.' success<br>';
                } else {
                    echo 'thumbH '.$huge.' failed<br>';
                }
            } else {
                echo 'thumbH '.$huge.' exists<br>';
            }

            $large = $video->imgur.'l.jpg';
            if (!file_exists('thumbnail/'.public_path($large))) {
                if (file_put_contents('thumbnail/'.$large, file_get_contents('https://i.imgur.com/'.$large))) {
                    echo 'thumbL '.$large.' success<br>';
                } else {
                    echo 'thumbL '.$large.' failed<br>';
                }
            } else {
                echo 'thumbL '.$large.' exists<br>';
            }
        } */

        //---------------------------------------------------------------------------------------------------------

        /* $downloads = [];
        $url = 'https://www.eporner.com/video-fjYBKJIK47f/twins-tail-sex-2/';
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($curl_connection);
        curl_close($curl_connection);

        $data = Helper::get_string_between($html, '<div class="dloaddivcol">', '</div>');
        $dom = new \DOMDocument();
        $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$data);
        $links = $dom->getElementsByTagName('a');
        foreach ($links as $link) {
            $res = Helper::get_string_between($link->textContent, 'Download MP4 (', 'p,');
            $href = 'https://www.eporner.com'.$link->getAttribute('href');
            $curl_connection = curl_init($href);
            curl_setopt($curl_connection, CURLOPT_HEADER, true);
            curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl_connection);
            curl_close($curl_connection);
            if (preg_match('~Location: (.*)~i', $result, $match)) {
               $location = trim($match[1]);
               $title = Helper::get_string_between($location, '?dload=', '.mp4');
               $location = str_replace($title, '思春期SEX 2 - Hanime1.me', $location);
               $downloads[$res] = $location;
            } else {

            }
        }
        return $downloads; */

        /* $videos = Video::where('sd', 'like', '%rule34%')->get();
        foreach ($videos as $video) {
            $video->outsource = true;
            $video->save();
        } */

        /* $videos = Video::where('sd', 'ilike', '%xvideos%')->where('foreign_sd', 'ilike', '%"error"%')->orderBy('id', 'desc')->get();
        foreach ($videos as $video) {
            $temp = $video->foreign_sd;
            $temp['xvideos'] = $video->foreign_sd['error'];
            unset($temp['error']);
            $video->foreign_sd = $temp;
            $video->save();
        } */

        /* $comics = Comic::orderBy('id', 'asc')->get();
        foreach ($comics as $comic) {
            $searchtext = $comic->title_n_before
                         .$comic->title_n_pretty
                         .$comic->title_n_after
                         .$comic->title_o_before
                         .$comic->title_o_pretty
                         .$comic->title_o_after
                         .implode($comic->parodies)
                         .implode($comic->characters)
                         .implode($comic->tags)
                         .implode($comic->artists)
                         .implode($comic->groups)
                         .implode($comic->languages)
                         .implode($comic->categories);
            $searchtext = mb_strtolower($searchtext);
            $searchtext = preg_replace('/\s+/', '', $searchtext);
            $searchtext = preg_split('//u', $searchtext, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($searchtext as &$character) {
                if (strlen($character) != mb_strlen($character, 'utf-8')) {
                    $character = bin2hex(iconv('UTF-8', 'UTF-16BE', $character));
                }
            }
            $searchtext = implode($searchtext);
            $comic->searchtext = $searchtext;
            $comic->save();
        } */

        /* $tags_array = [];
        $comics = Comic::orderBy('id', 'asc')->get();
        foreach ($comics as $comic) {
            $tags = $comic->tags;
            foreach ($tags as $tag) {
                if (array_key_exists($tag, $tags_array)) {
                    $tags_array[$tag] = $tags_array[$tag] + 1;
                } else {
                    $tags_array[$tag] = 1;
                }
            }
        }
        arsort($tags_array);
        return $tags_array; */

        /* $videos = Video::where('tags', 'ilike', '% 睡房 %')->get();
        foreach ($videos as $video) {
            $tags_array = $video->tags_array;
            unset($tags_array['睡房']);
            $video->tags_array = $tags_array;
            $video->tags = str_replace(' 睡房 ', ' ', $video->tags);
            $video->save();
        } */

        /* $videos = Video::where('tags', 'ilike', '%Queen Bee%')->get();
        foreach ($videos as $video) {
            $original_tags = $video->tags_array;
            $new_tags = [];
            foreach ($original_tags as $tag) {
                if ($tag == 'Queen') {
                    array_push($new_tags, 'Queen Bee');
                } elseif ($tag == 'Bee') {
                    // code...
                } else {
                    array_push($new_tags, $tag);
                }
            }
            $video->tags_array = $new_tags;
            $video->save();
        } */
    }

    public function checkAvbebeEporner(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $eporner_list = [];
        for ($i = 1; $i <= 66; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'https://www.eporner.com/embed/') !== false) {
                    $eporner = Helper::get_string_between($html, 'https://www.eporner.com/embed/', '/');
                    $eporner = 'https://www.eporner.com/embed/'.$eporner.'/';
                    if (!in_array($eporner, $eporner_list)) {
                        $curl_connection = curl_init($eporner);
                        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                        $html = curl_exec($curl_connection);
                        curl_close($curl_connection);

                        if (strpos($html, 'This video is no longer available.') === false) {
                            array_push($eporner_list, $eporner);
                            echo $eporner.'<br>';
                        }
                    }
                }
            }
        }
    }

    public function checkAvbebeMotherless(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $motherless_list = [];
        for ($i = 1; $i <= 66; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'motherless') !== false) {
                    if (strpos($html, '<iframe src="https://avbebe.com/wp-content/plugins/wp-tube-plugin/inc/tools/jwplayer/player.php?') !== false) {
                        $motherless = Helper::get_string_between($html, '<iframe src="https://avbebe.com/wp-content/plugins/wp-tube-plugin/inc/tools/jwplayer/player.php?', '"');
                        $motherless = explode('&id=', $motherless);
                        $motherless = 'https://motherless.com/'.end($motherless);

                    } elseif (strpos($html, 'https://cdn5-videos.motherlessmedia.com/videos/') !== false) {
                        $motherless = Helper::get_string_between($html, 'https://cdn5-videos.motherlessmedia.com/videos/', '.mp4');
                        $motherless = 'https://motherless.com/'.$motherless;
                    }

                    if (!in_array($motherless, $motherless_list)) {
                        $video = 'https://cdn5-videos.motherlessmedia.com/videos/'.str_replace('https://motherless.com/', '', $motherless).'.mp4';
                        $ch = curl_init($video);
                        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
                        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                        curl_setopt($ch, CURLOPT_TIMEOUT,10);
                        $output = curl_exec($ch);
                        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);

                        if ($httpcode != 302) {
                            array_push($motherless_list, $motherless);
                            echo $motherless.'<br>';
                        }
                    }
                }
            }
        }
    }

    public function checkAvbebeOdysee(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $odysee_list = [];
        for ($i = 1; $i <= 66; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'odysee') !== false) {
                    $odysee = 'https://odysee.com/'.Helper::get_string_between($html, 'src="https://odysee.com/', '"');
                    $name = Helper::get_string_between($odysee, 'https://odysee.com/$/embed/', '/');
                    $id = explode($name.'/', $odysee)[1];
                    $odysee = 'https://odysee.com/'.$name.':'.$id;
                    if (!in_array($odysee, $odysee_list)) {
                        array_push($odysee_list, $odysee);
                        echo '<a href="'.$odysee.'" target="_blank">'.$odysee.'</a><br>';
                    }
                }
            }
        }
    }

    public function checkAvbebeYoujizz(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $youjizz_list = [];
        for ($i = 66; $i >= 1; $i--) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'youjizz') !== false) {
                    $youjizz = 'https://www.youjizz.com/videos/embed/'.Helper::get_string_between($html, 'https://www.youjizz.com/videos/embed/', '"');
                    if (!in_array($youjizz, $youjizz_list)) {
                        array_push($youjizz_list, $youjizz);
                        echo '<a href="'.$youjizz.'" target="_blank">'.$youjizz.'</a><br>';
                    }
                }
            }
        }
    }

    public function checkAvbebeXvideos(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $xvideos_list = [];
        for ($i = 66; $i >= 1; $i--) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'xvideos') !== false) {
                    $xvideos = 'https://www.xvideos.com/embedframe/'.Helper::get_string_between($html, 'https://www.xvideos.com/embedframe/', '"');
                    if (!in_array($xvideos, $xvideos_list)) {
                        array_push($xvideos_list, $xvideos);
                        echo '<a href="'.$xvideos.'" target="_blank">'.$xvideos.'</a><br>';
                        echo '<a href="'.$href.'" target="_blank">'.$href.'</a><br>';
                        echo '<br>';
                    }
                }
            }
        }
    }

    public function checkAvbebeFembed(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $fembed_list = [];
        for ($i = 1; $i <= 64; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'https://www.fembed.com/v/') !== false) {
                    $fembed = 'https://www.fembed.com/v/'.Helper::get_string_between($html, 'https://www.fembed.com/v/', '"');
                    if (!in_array($fembed, $fembed_list)) {
                        array_push($fembed_list, $fembed);
                        echo '<a href="'.$fembed.'" target="_blank">'.$fembed.'</a><br>';
                    }
                } elseif (strpos($html, 'https://www.fembed.com/f/') !== false) {
                    $fembed = 'https://www.fembed.com/v/'.Helper::get_string_between($html, 'https://www.fembed.com/f/', '"');
                    if (!in_array($fembed, $fembed_list)) {
                        array_push($fembed_list, $fembed);
                        echo '<a href="'.$fembed.'" target="_blank">'.$fembed.'</a><br>';
                    }
                }
            }
        }
    }

    public function checkAvbebeMp4(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $avgigi_list = [];
        for ($i = 1; $i <= 66; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                $html = str_replace('&quot;', '"', $html);
                curl_close($curl_connection);

                while (strpos($html, 'https:\/\/v.avgigi.com') !== false || strpos($html, 'http:\/\/v.avgigi.com') !== false || strpos($html, 'https://v.avgigi.com') !== false || strpos($html, 'http://v.avgigi.com') !== false) {

                    if (strpos($html, 'https:\/\/v.avgigi.com') !== false) {
                        $avgigi = 'https:\/\/v.avgigi.com'.Helper::get_string_between($html, 'https:\/\/v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.mp4') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }

                    if (strpos($html, 'http:\/\/v.avgigi.com') !== false) {
                        $avgigi = 'http:\/\/v.avgigi.com'.Helper::get_string_between($html, 'http:\/\/v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.mp4') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }

                    if (strpos($html, 'https://v.avgigi.com') !== false) {
                        $avgigi = 'https://v.avgigi.com'.Helper::get_string_between($html, 'https://v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.mp4') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }

                    if (strpos($html, 'http://v.avgigi.com') !== false) {
                        $avgigi = 'http://v.avgigi.com'.Helper::get_string_between($html, 'http://v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.mp4') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }
                }
            }
        }
    }

    public function checkAvbebeM3u8(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $avgigi_list = [];
        for ($i = 1; $i <= 66; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                $html = str_replace('&quot;', '"', $html);
                curl_close($curl_connection);

                while (strpos($html, '.m3u8') !== false) {

                    if (strpos($html, 'https:\/\/v.avgigi.com') !== false) {
                        $avgigi = 'https:\/\/v.avgigi.com'.Helper::get_string_between($html, 'https:\/\/v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.m3u8') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }

                    if (strpos($html, 'http:\/\/v.avgigi.com') !== false) {
                        $avgigi = 'http:\/\/v.avgigi.com'.Helper::get_string_between($html, 'http:\/\/v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.m3u8') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }

                    if (strpos($html, 'https://v.avgigi.com') !== false) {
                        $avgigi = 'https://v.avgigi.com'.Helper::get_string_between($html, 'https://v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.m3u8') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }

                    if (strpos($html, 'http://v.avgigi.com') !== false) {
                        $avgigi = 'http://v.avgigi.com'.Helper::get_string_between($html, 'http://v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.m3u8') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }
                }
            }
        }
    }

    public function checkAvbebeOthers(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $others_list = [];
        for ($i = 1; $i <= 66; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'fembed') === false && strpos($html, 'odysee') === false && strpos($html, 'xvideos') === false && strpos($html, 'youjizz') === false && strpos($html, 'eporner') === false && strpos($html, 'motherless') === false && strpos($html, 'https://v.avgigi.com/') === false && strpos($html, 'http://v.avgigi.com/') === false && strpos($html, 'https://18av.mm-cg.com/') === false) {
                    if (!in_array($href, $others_list)) {
                        array_push($others_list, $href);
                        echo '<a href="'.$href.'" target="_blank">'.$href.'</a><br>';
                    }
                }
            }
        }
    }

    public function checkAvbebe3D(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $url = "https://avbebe.com/archives/category/3d%e5%8b%95%e7%95%ab";
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($curl_connection);
        curl_close($curl_connection);
        $pages = trim(Helper::get_string_between($html, '總頁數 ', ' 頁'));

        $news = [];
        for ($i = 1; $i <= $pages; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/3d%e5%8b%95%e7%95%ab';
            } else {
                $url = 'https://avbebe.com/archives/category/3d%e5%8b%95%e7%95%ab/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $links = explode('<h3 class="jeg_post_title">', $html);
            array_shift($links);
            foreach ($links as $block) {
                $link = trim(Helper::get_string_between($block, '<a href="', '"'));
                $title = trim(Helper::get_string_between($block, '<a href="'.$link.'">', '</a>'));
                $video = Video::where('foreign_sd', 'like', '%"'.$link.'"%')->first();
                if (!$video || strpos($title, '中文字幕') !== false && strpos($video->title, '中文字幕') === false) {
                    array_push($news, $link);
                }
            }
        }
        $news = array_diff($news, ["https://avbebe.com/archives/43608", "https://avbebe.com/archives/43606", "https://avbebe.com/archives/43141", "https://avbebe.com/archives/29773", "https://avbebe.com/archives/171102"]);
        return $news;
    }

    public function checkAvbebeHentai(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        Log::info('Avbebe hentai check started...');

        $url = "https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87";
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($curl_connection);
        curl_close($curl_connection);
        $pages = trim(Helper::get_string_between($html, '總頁數 ', ' 頁'));

        $news = [];
        for ($i = 1; $i <= $pages; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $links = explode('<h3 class="jeg_post_title">', $html);
            array_shift($links);
            foreach ($links as $block) {
                $link = trim(Helper::get_string_between($block, '<a href="', '"'));
                $title = trim(Helper::get_string_between($block, '<a href="'.$link.'">', '</a>'));
                $video = Video::where('foreign_sd', 'like', '%"'.$link.'"%')->first();
                if (!$video) {
                    array_push($news, $link);
                }
            }
        }
        $news = array_diff($news, ["https://avbebe.com/archives/66006", "https://avbebe.com/archives/66004", "https://avbebe.com/archives/36984"]);

        Log::info(json_encode($news)); 

        Log::info('Avbebe hentai check ended...');
    }

    public function editCaptions(Request $request)
    {
        $action = $request->action == 'check' ? route('bot.checkCaptions') : route('bot.updateCaptions');
        return view('layouts.editCaptions', compact('action'));
    }

    public function updateCaptions(Request $request)
    {
        $captions = $request->captions;
        $captions_array = explode(PHP_EOL, $captions);
        $originals = [];
        foreach ($captions_array as $value) {
            if (strpos($value, '-->') !== false) {
                array_push($originals, str_replace("\r", '', $value));
            }
        }

        // return $originals;

        $loop = 0;
        foreach ($originals as $original) {
            if ($loop <= count($originals) - 2) {
                $current = $innerLoop = 0;
                $current_time = explode(' --> ', $original)[1];
                $current_data = explode(':', $current_time);
                foreach ($current_data as $value) {
                    if ($value != '00') {
                        $temp = ltrim($value, '0');
                        switch ($innerLoop) {
                            case 0:
                                $current = $current + $temp * 60 * 60;
                                break;

                            case 1:
                                $current = $current + $temp * 60;
                                break;

                            case 2:
                                $current = $current + $temp;
                                break;
                        }
                    }
                    $innerLoop++;
                }

                $next = $innerLoop = 0;
                $next_time = explode(' --> ', $originals[$loop + 1])[0];
                $next_data = explode(':', $next_time);
                foreach ($next_data as $value) {
                    if ($value != '00') {
                        $temp = ltrim($value, '0');
                        switch ($innerLoop) {
                            case 0:
                                $next = $next + $temp * 60 * 60;
                                break;

                            case 1:
                                $next = $next + $temp * 60;
                                break;

                            case 2:
                                $next = $next + $temp;
                                break;
                        }
                    }
                    $innerLoop++;
                }

                if ($next > $current && $next - $current <= 2) {
                    $captions = str_replace($current_time, $next_time, $captions);
                }

                $loop++;
            }
        }

        return '<pre>'.$captions.'</pre>';
    }

    public function checkCaptions(Request $request)
    {
        $captions = $request->captions;
        $captions_array = explode(PHP_EOL, $captions);
        $originals = [];
        foreach ($captions_array as $value) {
            if (strpos($value, '-->') !== false) {
                array_push($originals, str_replace("\r", '', $value));
            }
        }

        // return $originals;

        $loop = 0;
        foreach ($originals as $original) {
            if ($loop <= count($originals) - 2) {
                $current = $innerLoop = 0;
                $current_time = explode(' --> ', $original)[1];
                $current_data = explode(':', $current_time);
                foreach ($current_data as $value) {
                    if ($value != '00') {
                        $temp = ltrim($value, '0');
                        switch ($innerLoop) {
                            case 0:
                                $current = $current + $temp * 60 * 60;
                                break;

                            case 1:
                                $current = $current + $temp * 60;
                                break;

                            case 2:
                                $current = $current + $temp;
                                break;
                        }
                    }
                    $innerLoop++;
                }

                $next = $innerLoop = 0;
                $next_time = explode(' --> ', $originals[$loop + 1])[0];
                $next_data = explode(':', $next_time);
                foreach ($next_data as $value) {
                    if ($value != '00') {
                        $temp = ltrim($value, '0');
                        switch ($innerLoop) {
                            case 0:
                                $next = $next + $temp * 60 * 60;
                                break;

                            case 1:
                                $next = $next + $temp * 60;
                                break;

                            case 2:
                                $next = $next + $temp;
                                break;
                        }
                    }
                    $innerLoop++;
                }

                if ($current > $next) {
                    echo $current_time.'<br>';
                }

                $loop++;
            }
        }
    }

    public function setVideoDuration(Request $request)
    {
        $video = Video::find($request->id);
        $video->duration = round($request->duration);
        $video->save();
    }

    public function getWatchesData(Request $request)
    {
        if ($request->username == 'appieopie' && $request->password == 'd0raemOn@(!$') {
            $watches = Watch::all()->toArray();
            return $watches;
        } else {
            abort(403);
        }
    }

    public function getVideosData(Request $request)
    {
        if ($request->username == 'appieopie' && $request->password == 'd0raemOn@(!$') {
            $videos = Video::all()->toArray();
            return $videos;
        } else {
            abort(403);
        }
    }

    public function updateCdn77(Request $request)
    {
        $url = 'vdownload.hembed.com';
        $expiration = time() + 43200;
        $token = 'xVEO8rLVgGkUBEBg';

        Log::info('Cdn77 update started...');

        $videos = Video::where('foreign_sd', 'like', '%"cdn77"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {
            $qualities = [];
            $source = str_replace('https://'.$url, '', $video->foreign_sd['cdn77']);
            if (strpos($source, '1080p') !== false) {
                $qualities['1080'] = Video::getSignedUrlParameter($url, $source, $token, $expiration);
                $source = str_replace('-1080p.mp4', '-720p.mp4', $source);
            }
            if (strpos($source, '720p') !== false) {
                $qualities['720'] = Video::getSignedUrlParameter($url, $source, $token, $expiration);
                $source = str_replace('-720p.mp4', '-480p.mp4', $source);
            }
            if (strpos($source, '480p') !== false) {
                $qualities['480'] = Video::getSignedUrlParameter($url, $source, $token, $expiration);
            }

            $video->sd = reset($qualities);
            $video->qualities = $qualities;
            $video->outsource = false;
            $video->save();

            Log::info('Cdn77 update ID#'.$video->id.' success...');
        }

        Log::info('Cdn77 update ended...');


        Log::info('Cdn77 sc update started...');

        $videos = Video::where('foreign_sd', 'like', '%"cdn77_sc"%')->select('id', 'title', 'sd_sc', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {
            $qualities_sc = [];
            $source_sc = str_replace('https://'.$url, '', $video->foreign_sd['cdn77_sc']);
            if (strpos($source_sc, '1080p') !== false) {
                $qualities_sc['1080'] = Video::getSignedUrlParameter($url, $source_sc, $token, $expiration);
                $source_sc = str_replace('-1080p.mp4', '-720p.mp4', $source_sc);
            }
            if (strpos($source_sc, '720p') !== false) {
                $qualities_sc['720'] = Video::getSignedUrlParameter($url, $source_sc, $token, $expiration);
                $source_sc = str_replace('-720p.mp4', '-480p.mp4', $source_sc);
            }
            if (strpos($source_sc, '480p') !== false) {
                $qualities_sc['480'] = Video::getSignedUrlParameter($url, $source_sc, $token, $expiration);
            }

            $video->sd_sc = reset($qualities_sc);
            $video->qualities_sc = $qualities_sc;
            $video->outsource = false;
            $video->save();

            Log::info('Cdn77 sc update ID#'.$video->id.' success...');
        }

        Log::info('Cdn77 sc update ended...');
    }

    public function updateSpankbang(Request $request)
    {
        if ($number = $request->number && $total = $request->total) {
            Spankbang::updateSpankbang($number, $total);
        } else {
            Spankbang::updateSpankbang(1, 1);
        }
    }

    public function updateSpankbangSc(Request $request)
    {
        if ($number = $request->number && $total = $request->total) {
            Spankbang::updateSpankbangSc($number, $total);
        } else {
            Spankbang::updateSpankbangSc(1, 1);
        }
    }

    public function updateSpankbangErrors()
    {
        Spankbang::updateSpankbangErrors();
    }

    public function checkSpankbangOutdate()
    {
        Spankbang::checkSpankbangOutdate();
    }

    public function checkSpankbangOutdateEmergent()
    {
        Spankbang::checkSpankbangOutdateEmergent();
    }

    public function checkSpankbangUpdate()
    {
        Spankbang::checkSpankbangUpdate();
    }

    public function resetSpankbangErrors()
    {
        Spankbang::resetSpankbangErrors();
    }

    public function updateYoujizz(Request $request)
    {
        Youjizz::updateYoujizz();
    }

    public function updateYoujizzDownloads()
    {
        Youjizz::updateYoujizzDownloads();
    }

    public function updateYoujizzDownloadsSc()
    {
        Youjizz::updateYoujizzDownloadsSc();
    }

    public function updateYoujizzErrors()
    {
        Youjizz::updateYoujizzErrors();
    }

    public function checkYoujizz()
    {
        Youjizz::checkYoujizz();
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
            curl_setopt($curl_connection, CURLOPT_HTTPHEADER, [
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:56.0) Gecko/20100101 Firefox/56.0',
                'Host: www.xvideos.com',
                'Referer: https://www.xvideos.com/account/uploads',
                'Cookie: _ga=GA1.2.979984912.1619035848; _ym_uid=1619035986805725121; _ym_d=1619035986; session_ath=light; wpn_ad_cookie=2d7f6a1b6557fcc3541c8ebd155a6a5b; cit=269de96f64d643f8trKNZ2h_p6KD2L8rLS3CME_iWTcxNWvJR_pQBO01jq-cWTzY2DtjOOAaD2nvL3sm; static_cdn=st; html5_pref=%7B%22SQ%22%3Afalse%2C%22MUTE%22%3Afalse%2C%22VOLUME%22%3A0.2222222222222222%2C%22FORCENOPICTURE%22%3Afalse%2C%22FORCENOAUTOBUFFER%22%3Afalse%2C%22FORCENATIVEHLS%22%3Afalse%2C%22PLAUTOPLAY%22%3Atrue%2C%22CHROMECAST%22%3Afalse%2C%22EXPANDED%22%3Afalse%2C%22FORCENOLOOP%22%3Afalse%7D; xv_nbview=-1; __atssc=google%3B3; html5_networkspeed=23283; __atuvc=0%7C35%2C0%7C36%2C0%7C37%2C12%7C38%2C14%7C39; XVUPLOADSESSION=r8rhm1j3p8pnvf59plp1lq7ij8; X-Backend=12|YVSpX|YVSST; last_subs_check=1; last_views=%5B%2253036937-1619123059%22%2C%2252987433-1619123110%22%2C%2260530141-1619364342%22%2C%2260541891-1619609287%22%2C%2257081613-1619616167%22%2C%2259053767-1620147541%22%2C%2261076445-1620202020%22%2C%2262164807-1620301637%22%2C%2220041059-1620758693%22%2C%2241445071-1620758717%22%2C%2233033023-1620758722%22%2C%2211413559-1620758725%22%2C%2249865955-1620758828%22%2C%2262860583-1620980751%22%2C%2261138175-1621234385%22%2C%2243248989-1621252866%22%2C%2257718577-1622190023%22%2C%2257550447-1622190034%22%2C%2257608373-1622190044%22%2C%2263169015-1622201727%22%2C%2263169151-1622201782%22%2C%2263169499-1622201783%22%2C%2263169551-1622201948%22%2C%2263170473-1622228354%22%2C%2262628061-1623747917%22%2C%2235826351-1623747919%22%2C%2263593625-1626265676%22%2C%2263969411-1626265753%22%2C%2259686393-1626539796%22%2C%2264397887-1627707826%22%2C%2257349879-1627730261%22%2C%2264563787-1628413019%22%2C%2264608799-1628964435%22%2C%2264910597-1629790218%22%2C%2264958809-1629970793%22%2C%2265266759-1631781112%22%2C%2265286145-1631791698%22%2C%2238763731-1632030996%22%2C%2223800858-1632031061%22%2C%2229761517-1632031077%22%2C%2265379407-1632145156%22%2C%2265379637-1632145302%22%2C%2265378687-1632145718%22%2C%2265379913-1632145787%22%2C%2265401981-1632232376%22%2C%2265403877-1632242072%22%2C%2265405785-1632248395%22%2C%2265408449-1632289614%22%2C%2229297141-1632290460%22%2C%2260169631-1632290469%22%2C%2210984616-1632290512%22%2C%2264561087-1632471435%22%2C%2265436107-1632498742%22%2C%2265436219-1632498752%22%2C%2265437969-1632499410%22%2C%2258553571-1632804041%22%2C%2265554077-1632910817%22%2C%2265554185-1632910895%22%2C%2265554323-1632910998%22%2C%2265554409-1632911054%22%2C%2265554479-1632911091%22%2C%2265556777-1632923951%22%2C%2265556595-1632923953%22%2C%2265556679-1632923952%22%2C%2265557267-1632924813%22%2C%2265557401-1632924817%22%2C%2265557513-1632924824%22%2C%2265558055-1632926151%22%2C%2265558435-1632926159%22%2C%2265555977-1632926734%22%2C%2265562135-1632938470%22%5D; session_token=f724a93c1a442aadPk15NWO3TyccV19C5MmAd3HqP_yMLKsLYxD5JBA7e07_jPTwbHEhZ3tz5sY-dv4IHDqT-T7psbYsaKLcY0Pf_sBuy5pnAogivEatPnlbchcPWfoS_8CsH_gMz55qRriJz_tvuYqxcaUFSflswR3fpkhvN8MDRWeUbvCdFrb1uS8VBUP1-tW49mAiLqvI9Ok7mGXgBCUZ8K2o89xno_zl-b1SQ2RMhCuFzJQZXS5tnlSd1-wMWgkVp11-PsNCQVSb6CIFv3khK1DgnNzjD0o85MvMr-oKUSRS1QJeoRBfcUHKd_5VY_0d7aIvn6qqp1sK3Kde77xA_g9FTWhbQyHHSGye3KdBUK-LLFH8AN7sev3iyfIIjODP609CajpXmZPnEf5N8YhpemLS3dxNSOk08qroPaWNiUPz1I4kRaxCXpV2A65a2PKbuLwkeTGERkG5tq_XYKQYC-csFHwe-AeIfO_FhYPCLg1KAv9K-QqAbIvN1rq56ASq9THnuC2tGzXok1SOcDFVpvHh7-6T3ChM7g%3D%3D'
            ]);
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

    public function checkMotherless()
    {
        Motherless::checkMotherless();
    }

    public function addHembedSource(Request $request)
    {
        $quality = $request->quality ? $request->quality : '720p';
        $vid = $request->v;
        if (is_numeric($vid) && $video = Video::select('id', 'sd', 'foreign_sd')->find($vid)) {
            $temp = $video->foreign_sd;
            $temp['hembed'] = 'https://vdownload.hembed.com/'.$video->id.'-'.$quality.'.mp4';
            $video->foreign_sd = $temp;
            $video->save();
            return 'Updated';
        }
        return '403 Forbidden';
    }

    public function addBalancerSource(Request $request)
    {
        $balancer = $request->balancer ? $request->balancer : '1';
        $quality = $request->quality ? $request->quality : '720p';
        $vid = $request->v;

        if (is_numeric($vid) && $video = Video::select('id', 'sd', 'foreign_sd')->find($vid)) {
            $sd = $source = "https://vbalancer-{$balancer}.hembed.com/{$vid}-{$quality}.mp4";
            $qualities = [];
            if (strpos($source, '1080p') !== false) {
                $qualities['1080'] = "https://vbalancer-{$balancer}.hembed.com/{$vid}-1080p.mp4";
                $source = str_replace('-1080p.mp4', '-720p.mp4', $source);
            }
            if (strpos($source, '720p') !== false) {
                $qualities['720'] = "https://vbalancer-{$balancer}.hembed.com/{$vid}-720p.mp4";
                $source = str_replace('-720p.mp4', '-480p.mp4', $source);
            }
            if (strpos($source, '480p') !== false) {
                $qualities['480'] = "https://vbalancer-{$balancer}.hembed.com/{$vid}-480p.mp4";
            }
            $video->sd = $sd;
            $video->qualities = $qualities;

            $sd_sc = $source_sc = "https://vbalancer-{$balancer}.hembed.com/{$vid}-sc-{$quality}.mp4";
            $qualities_sc = [];
            if (strpos($source_sc, '1080p') !== false) {
                $qualities_sc['1080'] = "https://vbalancer-{$balancer}.hembed.com/{$vid}-sc-1080p.mp4";
                $source_sc = str_replace('-1080p.mp4', '-720p.mp4', $source_sc);
            }
            if (strpos($source_sc, '720p') !== false) {
                $qualities_sc['720'] = "https://vbalancer-{$balancer}.hembed.com/{$vid}-sc-720p.mp4";
                $source_sc = str_replace('-720p.mp4', '-480p.mp4', $source_sc);
            }
            if (strpos($source_sc, '480p') !== false) {
                $qualities_sc['480'] = "https://vbalancer-{$balancer}.hembed.com/{$vid}-sc-480p.mp4";
            }
            $video->sd_sc = $sd_sc;
            $video->qualities_sc = $qualities_sc;

            $video->save();

            return Redirect::route('video.watch', ['v' => $video->id]);
        }
        return '403 Forbidden';
    }

    public function addCdn77Source(Request $request)
    {
        $quality = $request->quality ? $request->quality : '720p';
        $vid = $request->v;

        $url = 'vdownload.hembed.com';
        $expiration = time() + 43200;
        $token = 'xVEO8rLVgGkUBEBg';

        if (is_numeric($vid) && $video = Video::select('id', 'sd', 'foreign_sd')->find($vid)) {
            $qualities = [];
            $sd = $source = "/{$vid}-{$quality}.mp4";
            if (strpos($source, '1080p') !== false) {
                $qualities['1080'] = Video::getSignedUrlParameter($url, $source, $token, $expiration);
                $source = str_replace('-1080p.mp4', '-720p.mp4', $source);
            }
            if (strpos($source, '720p') !== false) {
                $qualities['720'] = Video::getSignedUrlParameter($url, $source, $token, $expiration);
                $source = str_replace('-720p.mp4', '-480p.mp4', $source);
            }
            if (strpos($source, '480p') !== false) {
                $qualities['480'] = Video::getSignedUrlParameter($url, $source, $token, $expiration);
            }
            $video->sd = reset($qualities);
            $video->qualities = $qualities;
            $foreign_sd = $video->foreign_sd;
            $foreign_sd['cdn77'] = "https://".$url.$sd;
            $video->foreign_sd = $foreign_sd;
            $video->save();

            $qualities_sc = [];
            $sd_sc = $source_sc = "/{$vid}-sc-{$quality}.mp4";
            if (strpos($source_sc, '1080p') !== false) {
                $qualities_sc['1080'] = Video::getSignedUrlParameter($url, $source_sc, $token, $expiration);
                $source_sc = str_replace('-1080p.mp4', '-720p.mp4', $source_sc);
            }
            if (strpos($source_sc, '720p') !== false) {
                $qualities_sc['720'] = Video::getSignedUrlParameter($url, $source_sc, $token, $expiration);
                $source_sc = str_replace('-720p.mp4', '-480p.mp4', $source_sc);
            }
            if (strpos($source_sc, '480p') !== false) {
                $qualities_sc['480'] = Video::getSignedUrlParameter($url, $source_sc, $token, $expiration);
            }
            $video->sd_sc = reset($qualities_sc);
            $video->qualities_sc = $qualities_sc;
            $foreign_sd = $video->foreign_sd;
            $foreign_sd['cdn77_sc'] = "https://".$url.$sd_sc;
            $video->foreign_sd = $foreign_sd;
            $video->save();

            return Redirect::route('video.watch', ['v' => $video->id]);
        }
        return '403 Forbidden';
    }

    public function addCdn77SourceTemp(Request $request)
    {
        $quality = $request->quality ? $request->quality : '720p';
        $vid = $request->v;

        $url = 'vdownload.hembed.com';
        $expiration = time() + 43200;
        $token = 'xVEO8rLVgGkUBEBg';

        if (is_numeric($vid) && $video = Video::select('id', 'sd', 'foreign_sd')->find($vid)) {
            $qualities = [];
            $sd = $source = "/{$vid}-{$quality}.mp4";
            if (strpos($source, '1080p') !== false) {
                $qualities['1080'] = Video::getSignedUrlParameter($url, $source, $token, $expiration);
                $source = str_replace('-1080p.mp4', '-720p.mp4', $source);
            }
            if (strpos($source, '720p') !== false) {
                $qualities['720'] = Video::getSignedUrlParameter($url, $source, $token, $expiration);
                $source = str_replace('-720p.mp4', '-480p.mp4', $source);
            }
            if (strpos($source, '480p') !== false) {
                $qualities['480'] = Video::getSignedUrlParameter($url, $source, $token, $expiration);
            }
            $video->sd = reset($qualities);
            $video->qualities = $qualities;
            $video->outsource = false;
            $foreign_sd = $video->foreign_sd;
            $foreign_sd['cdn77'] = "https://".$url.$sd;
            $foreign_sd['cdn77_temp'] = "true";
            $video->foreign_sd = $foreign_sd;
            $video->save();

            return Redirect::route('video.watch', ['v' => $video->id]);
        }
        return '403 Forbidden';
    }

    public function uploadRule34(Request $request)
    {
        $artists = Rule34::$artists;
        $user = array_rand($artists);
        $url = $artists[$user];

        $user = User::find($user);
        Log::info('Rule34 user '.$user->name.' upload started...');
        $video_links = [];
        $html = Browsershot::url($url)
                ->timeout(3600)
                ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                ->bodyHtml();

        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $links = $dom->getElementsByTagName('a');
        foreach ($links as $link) {
            $id = $link->getAttribute('id');
            if ($id != '') {
                array_push($video_links, 'https://rule34.xxx/'.$link->getAttribute('href'));
            }
        }

        $playlist = $user->watches->first();
        $duplicated = Rule34::$duplicated;
        foreach ($video_links as $link) {
            $queries = [];
            parse_str($link, $queries);
            $rule_id = $queries['id'];
            if (!empty($rule_id) && !Video::where('sd', 'like', '%?'.$rule_id)->exists() && !Video::where('foreign_sd', 'like', '%'.$rule_id.'"%')->exists() && !in_array($rule_id, $duplicated)) {
                $html = Browsershot::url($link)
                ->timeout(3600)
                ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                ->bodyHtml();

                $character = Helper::get_string_between($html, '<li class="tag-type-character tag">', '</li>');
                $dom = new \DOMDocument();
                $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$character);
                $hyperlinks = $dom->getElementsByTagName('a');
                foreach ($hyperlinks as $hyperlink) {
                    $character = $hyperlink->nodeValue;
                }

                $copyright = Helper::get_string_between($html, '<li class="tag-type-copyright tag">', '</li>');
                $dom = new \DOMDocument();
                $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$copyright);
                $hyperlinks = $dom->getElementsByTagName('a');
                foreach ($hyperlinks as $hyperlink) {
                    $copyright = $hyperlink->nodeValue;
                }

                $title = '['.$user->name.'] '.$character.' ['.$copyright.']';

                $tags = [];
                $tag_sidebar = Helper::get_string_between($html, '<ul id="tag-sidebar">', '</ul>');
                $dom = new \DOMDocument();
                $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$tag_sidebar);
                $hyperlinks = $dom->getElementsByTagName('a');
                foreach ($hyperlinks as $hyperlink) {
                    $tags[$hyperlink->nodeValue] = 10;
                }
                $tags['同人'] = 10;

                $sd = Helper::get_string_between($html, '<source src="', '"');
                $created_at = Helper::get_string_between($html, 'Posted: ', '<br>');

                if (!empty($sd) && strpos($sd, 'ackcdn.net') === false) {
                    $video = Video::create([
                        'user_id' => $user->id,
                        'playlist_id' => $playlist->id,
                        'title' => $title,
                        'translations' => ['JP' => $title],
                        'caption' => $title,
                        'sd' => $sd,
                        'imgur' => 'WENZTSJ',
                        'tags' => implode(' ', array_keys($tags)),
                        'tags_array' => $tags,
                        'current_views' => 0,
                        'views' => 0,
                        'outsource' => true,
                        'foreign_sd' => ['rule34' => $sd],
                        'cover' => 'https://i.imgur.com/E6mSQA2.png',
                        'created_at' => $created_at,
                        'uploaded_at' => Carbon::now(),
                    ]);
                }

                Rule34::translateRule34();
            }
        }

        Log::info('Rule34 user '.$user->name.' upload ended...');
    }

    public function updateHembed()
    {
        Log::info('Hembed update started...');

        $videos = Video::where('foreign_sd', 'like', '%"hembed"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {
            $qualities = [];
            $source = $video->foreign_sd['hembed'];
            if (strpos($source, '1080p') !== false) {
                $qualities['1080'] = Helper::sign_bcdn_url($source, env('BUNNY_TOKEN'), 43200);
                $source = str_replace('-1080p.mp4', '-720p.mp4', $source);
            }
            if (strpos($source, '720p') !== false) {
                $qualities['720'] = Helper::sign_bcdn_url($source, env('BUNNY_TOKEN'), 43200);
                $source = str_replace('-720p.mp4', '-480p.mp4', $source);
            }
            if (strpos($source, '480p') !== false) {
                $qualities['480'] = Helper::sign_bcdn_url($source, env('BUNNY_TOKEN'), 43200);
                $source = str_replace('-480p.mp4', '-240p.mp4', $source);
            }
            if (strpos($source, '240p') !== false) {
                $qualities['240'] = Helper::sign_bcdn_url($source, env('BUNNY_TOKEN'), 43200);
            }

            $video->sd = reset($qualities);
            $video->qualities = $qualities;
            $video->outsource = false;

            if (strpos($source, '1080p') === false && 
                strpos($source, '720p') === false && 
                strpos($source, '480p') === false && 
                strpos($source, '240p') === false) {
                $video->sd = Helper::sign_bcdn_url($source, env('BUNNY_TOKEN'), 43200);
                $video->qualities = null;
            }

            $video->save();

            Log::info('Hembed update ID#'.$video->id.' success...');
        }

        Log::info('Hembed update ended...');


        Log::info('Hembed sc update started...');

        $videos = Video::where('foreign_sd', 'like', '%"hembed_sc"%')->select('id', 'title', 'sd_sc', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {
            $qualities_sc = [];
            $source_sc = $video->foreign_sd['hembed_sc'];
            if (strpos($source_sc, '1080p') !== false) {
                $qualities_sc['1080'] = Helper::sign_bcdn_url($source_sc, env('BUNNY_TOKEN'), 43200);
                $source_sc = str_replace('-1080p.mp4', '-720p.mp4', $source_sc);
            }
            if (strpos($source_sc, '720p') !== false) {
                $qualities_sc['720'] = Helper::sign_bcdn_url($source_sc, env('BUNNY_TOKEN'), 43200);
                $source_sc = str_replace('-720p.mp4', '-480p.mp4', $source_sc);
            }
            if (strpos($source_sc, '480p') !== false) {
                $qualities_sc['480'] = Helper::sign_bcdn_url($source_sc, env('BUNNY_TOKEN'), 43200);
                $source_sc = str_replace('-480p.mp4', '-240p.mp4', $source_sc);
            }
            if (strpos($source_sc, '240p') !== false) {
                $qualities_sc['240'] = Helper::sign_bcdn_url($source_sc, env('BUNNY_TOKEN'), 43200);
            }

            $video->sd_sc = reset($qualities_sc);
            $video->qualities_sc = $qualities_sc;
            $video->outsource = false;

            if (strpos($source_sc, '1080p') === false && 
                strpos($source_sc, '720p') === false && 
                strpos($source_sc, '480p') === false && 
                strpos($source_sc, '240p') === false) {
                $video->sd_sc = Helper::sign_bcdn_url($source_sc, env('BUNNY_TOKEN'), 43200);
                $video->qualities_sc = null;
            }
            
            $video->save();

            Log::info('Hembed sc update ID#'.$video->id.' success...');
        }

        Log::info('Hembed sc update ended...');
    }

    public function updateVod()
    {
        Log::info('Vod update started...');

        $videos = Video::where('foreign_sd', 'like', '%"vod"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {
            $qualities = [];
            $source = $video->foreign_sd['vod'];
            if (strpos($source, '1080p') !== false) {
                $qualities['1080'] = Helper::sign_hembed_url($source, env('HEMBED_TOKEN'), 43200);
                $source = str_replace('-1080p.mp4', '-720p.mp4', $source);
            }
            if (strpos($source, '720p') !== false) {
                $qualities['720'] = Helper::sign_hembed_url($source, env('HEMBED_TOKEN'), 43200);
                $source = str_replace('-720p.mp4', '-480p.mp4', $source);
            }
            if (strpos($source, '480p') !== false) {
                $qualities['480'] = Helper::sign_hembed_url($source, env('HEMBED_TOKEN'), 43200);
                // $source = str_replace('-480p.mp4', '-240p.mp4', $source);
            }
            /* if (strpos($source, '240p') !== false) {
                $qualities['240'] = Helper::sign_hembed_url($source, env('HEMBED_TOKEN'), 43200);
            } */

            $video->sd = reset($qualities);
            $video->qualities = $qualities;
            $video->outsource = false;
            $video->save();

            Log::info('Vod update ID#'.$video->id.' success...');
        }

        Log::info('Vod update ended...');


        Log::info('Vod sc update started...');

        $videos = Video::where('foreign_sd', 'like', '%"vod_sc"%')->select('id', 'title', 'sd_sc', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {
            $qualities_sc = [];
            $source_sc = $video->foreign_sd['vod_sc'];
            if (strpos($source_sc, '1080p') !== false) {
                $qualities_sc['1080'] = Helper::sign_hembed_url($source_sc, env('HEMBED_TOKEN'), 43200);
                $source_sc = str_replace('-1080p.mp4', '-720p.mp4', $source_sc);
            }
            if (strpos($source_sc, '720p') !== false) {
                $qualities_sc['720'] = Helper::sign_hembed_url($source_sc, env('HEMBED_TOKEN'), 43200);
                $source_sc = str_replace('-720p.mp4', '-480p.mp4', $source_sc);
            }
            if (strpos($source_sc, '480p') !== false) {
                $qualities_sc['480'] = Helper::sign_hembed_url($source_sc, env('HEMBED_TOKEN'), 43200);
                // $source_sc = str_replace('-480p.mp4', '-240p.mp4', $source_sc);
            }
            /* if (strpos($source_sc, '240p') !== false) {
                $qualities_sc['240'] = Helper::sign_hembed_url($source_sc, env('HEMBED_TOKEN'), 43200);
            } */

            $video->sd_sc = reset($qualities_sc);
            $video->qualities_sc = $qualities_sc;
            $video->outsource = false;
            $video->save();

            Log::info('Vod sc update ID#'.$video->id.' success...');
        }

        Log::info('Vod sc update ended...');
    }

    public function editM3u8(Request $request)
    {
        return view('video.edit-m3u8');
    }

    public function updateM3u8(Request $request)
    {
        $m3u8 = $request->m3u8;
        $user0 = $request->user0;
        $user1 = $request->user1;
        $user2 = $request->user2;
        $lang = $request->lang;
        $base = trim(Helper::get_string_between($m3u8, ',', '0.ts'));
        for ($i = 0; $i <= 10000; $i++) { 
            if ($i % 3 == 0) {
                $m3u8 = str_replace("{$base}{$i}.ts", "https://cdn.jsdelivr.net/gh/{$user0}/{$user0}@v1.0.0/asset/{$lang}/0/p_{$i}.html", $m3u8);
            }
            if ($i % 3 == 1) {
                $m3u8 = str_replace("{$base}{$i}.ts", "https://cdn.jsdelivr.net/gh/{$user1}/{$user1}@v1.0.0/asset/{$lang}/1/p_{$i}.html", $m3u8);
            }
            if ($i % 3 == 2) {
                $m3u8 = str_replace("{$base}{$i}.ts", "https://cdn.jsdelivr.net/gh/{$user2}/{$user2}@v1.0.0/asset/{$lang}/2/p_{$i}.html", $m3u8);
            }
        }
        return '<pre>'.$m3u8.'</pre>';
    }

    public function translateRule34()
    {
        Rule34::translateRule34();
    }

    public function uploadCosplayjav(Request $request)
    {
        Cosplayjav::uploadCosplayjav($request->url);
    }

    public function translateCosplayjav()
    {
        Cosplayjav::translateCosplayjav();
    }

    public function uploadHtmlNhentai(Request $request)
    {
        return view('layouts.uploadHtmlNhentai');
    }

    public function uploadNhentai(Request $request)
    {
        // Nhentai::uploadNhentai();

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $type = request('nhentai-type');

        if ($type == 'list') {
            $nhentai_ids = [];
            $html = request('nhentai-html');
            $start = explode('<div class="container index-container">', $html);
            $end = explode('</div><section class="pagination">' , $start[1]);
            $galleries = $end[0];

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$galleries);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                array_push($nhentai_ids, Helper::get_string_between($link->getAttribute('href'), '/g/', '/'));
            }

            foreach ($nhentai_ids as $nhentai_id) {
                if (!Comic::where('nhentai_id', $nhentai_id)->exists()) {
                    $url = 'https://nhentai.net/g/'.$nhentai_id.'/';
                    // echo '<a href="view-source:'.$url.'" target="_blank">'.$url.'</a><br>';
                    echo 'view-source:'.$url.'<br>';
                }
            }

        } elseif ($type == 'show') {
            $html = request('nhentai-html');

            $galleries_id = Helper::get_string_between($html, 'nhentai.net/galleries/', '/');

            if (!Comic::where('galleries_id', $galleries_id)->exists()) {

                $title_n = Helper::get_string_between($html, '<h1 class="title">', '</h1>');
                $title_n_before = trim(Helper::get_string_between($title_n, '<span class="before">', '</span>'));
                $title_n_pretty = trim(Helper::get_string_between($title_n, '<span class="pretty">', '</span>'));
                $title_n_after = trim(Helper::get_string_between($title_n, '<span class="after">', '</span>'));

                $title_o = Helper::get_string_between($html, '<h2 class="title">', '</h2>');
                $title_o_before = trim(Helper::get_string_between($title_o, '<span class="before">', '</span>'));
                $title_o_pretty = trim(Helper::get_string_between($title_o, '<span class="pretty">', '</span>'));
                $title_o_after = trim(Helper::get_string_between($title_o, '<span class="after">', '</span>'));


                $parodies = Nhentai::getNhentaiTags($html, 'Parodies:');
                $characters = Nhentai::getNhentaiTags($html, 'Characters:');
                $tags = Nhentai::getNhentaiTags($html, 'Tags:');
                $artists = Nhentai::getNhentaiTags($html, 'Artists:');
                $groups = Nhentai::getNhentaiTags($html, 'Groups:');
                $languages = Nhentai::getNhentaiTags($html, 'Languages:');
                $categories = Nhentai::getNhentaiTags($html, 'Categories:');
                $pages = Nhentai::getNhentaiTags($html, 'Pages:')[0];
                $created_at = str_replace('T', ' ', explode('.', Helper::get_string_between($html, 'datetime="', '"'))[0]);

                $extension = '';
                $url = 'https://t.nhentai.net/galleries/'.$galleries_id.'/cover.jpg';
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_HEADER, true);    // we want headers
                curl_setopt($curl_connection, CURLOPT_NOBODY, true);    // we don't need body
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER,1);
                curl_setopt($curl_connection, CURLOPT_TIMEOUT,10);
                $output = curl_exec($curl_connection);
                $httpcode = curl_getinfo($curl_connection, CURLINFO_HTTP_CODE);
                curl_close($curl_connection);
                if ($httpcode == 200) {
                    $extension = 'jpg';
                } elseif ($httpcode == 404) {
                    $extension = 'png';
                } else {
                    die();
                }

                $extensions = [];
                $data = Helper::get_string_between($html, 'window._gallery = JSON.parse("', '")');
                $data = json_decode(json_decode('"'.$data.'"'), true);
                foreach ($data['images']['pages'] as $page) {
                    array_push($extensions, $page['t']);
                }

                $comic = Comic::create([
                    'nhentai_id' => $data['id'],
                    'galleries_id' => $galleries_id,
                    'title_n_before' => html_entity_decode($title_n_before, ENT_QUOTES, 'UTF-8'),
                    'title_n_pretty' => html_entity_decode($title_n_pretty, ENT_QUOTES, 'UTF-8'),
                    'title_n_after' => html_entity_decode($title_n_after, ENT_QUOTES, 'UTF-8'),
                    'title_o_before' => html_entity_decode($title_o_before, ENT_QUOTES, 'UTF-8'),
                    'title_o_pretty' => html_entity_decode($title_o_pretty, ENT_QUOTES, 'UTF-8'),
                    'title_o_after' => html_entity_decode($title_o_after, ENT_QUOTES, 'UTF-8'),
                    'parodies' => $parodies,
                    'characters' => $characters,
                    'tags' => $tags,
                    'artists' => $artists,
                    'groups' => $groups,
                    'languages' => $languages,
                    'categories' => $categories,
                    'pages' => $pages,
                    'extension' => $extension,
                    'extensions' => $extensions,
                    'created_at' => $created_at,
                ]);

                $searchtext = $comic->title_n_before
                             .$comic->title_n_pretty
                             .$comic->title_n_after
                             .$comic->title_o_before
                             .$comic->title_o_pretty
                             .$comic->title_o_after
                             .implode($comic->parodies)
                             .implode($comic->characters)
                             .implode($comic->tags)
                             .implode($comic->artists)
                             .implode($comic->groups)
                             .implode($comic->languages)
                             .implode($comic->categories);
                $searchtext = mb_strtolower($searchtext);
                $searchtext = preg_replace('/\s+/', '', $searchtext);
                $searchtext = preg_split('//u', $searchtext, -1, PREG_SPLIT_NO_EMPTY);
                foreach ($searchtext as &$character) {
                    if (strlen($character) != mb_strlen($character, 'utf-8')) {
                        $character = bin2hex(iconv('UTF-8', 'UTF-16BE', $character));
                    }
                }
                $searchtext = implode($searchtext);
                $comic->searchtext = $searchtext;
                $comic->save();

                $nhentai_ids = [];
                $comics = Comic::orderBy('id', 'desc')->limit(100)->get();
                foreach ($comics as $comic) {
                    if (!in_array($comic->nhentai_id, $nhentai_ids)) {
                        array_push($nhentai_ids, $comic->nhentai_id);
                    } else {
                        $comic->delete();
                    }
                }
            }

            return Redirect::back();
        }
    }

    public function translateNhentaiTag(Request $request)
    {
        Nhentai::translateNhentaiTag($request->replace);
    }

    public function comments(Request $request)
    {   
        $comments = Comment::with('user')->with('video:id,title')->with('preview:id,uuid')->orderBy('created_at', 'desc')->paginate(100);
        $comments->setPath('');
        return view('layouts.comments', compact('comments')); 
    }

    public function views(Request $request)
    {   
        $videos = Video::where('sd', 'like', '%vbalancer-1%')->select('id', 'current_views')->get();
        $current_views = $videos->sum('current_views');
        echo "vbalancer-1: {$current_views}<br>";
    }

    public function clearLaravelLogs()
    {   
        $files = Arr::where(Storage::disk('log')->files(), function($filename) {
            return Str::endsWith($filename,'.log');
        });


        $count = count($files);

        if(Storage::disk('log')->delete($files)) {
            Log::info(sprintf('Deleted %s %s!', $count, Str::plural('file', $count)));
        } else {
            Log::info('Error in deleting log files!');
        }
    }

    public function reset(Request $request)
    {
        $vid = $request->v;

        if (is_numeric($vid) && $video = Video::select('id', 'tags_array')->find($vid)) {
            $tags_array = $video->tags_array;
            foreach ($tags_array as $key => $value) {
                if ($value == 1) {
                    unset($tags_array[$key]);
                }
            }
            $video->tags_array = $tags_array;
            $video->save();
            echo "Newly added tags removed from ID#".$video->id;
        }
    }

    public function downloadAvbebeM3u8(Request $request)
    {
        $vid = str_replace('https://avbebe.com/archives/', '', $request->url);
        $m3u8 = "https://v.avgigi.com/acg/3D/{$vid}/video.m3u8";
        $referer = "https://avgigi.com/";
        $opts = [
            'http' => [
               'header' => [
                    "Referer: https://avgigi.com/"
                ]
            ]
        ];
        $context = stream_context_create($opts);
        Storage::disk('local')->put("video/{$vid}.m3u8", file_get_contents($m3u8, false, $context));

        for ($i = 0; $i <= 10000; $i++) { 
            $url = "https://v.avgigi.com/acg/3D/{$vid}/video{$i}.ts";
            Storage::disk('local')->put("video/{$vid}{$i}.ts", file_get_contents($url, false, $context));
        }
    }

    public function downloadAvbebeMp4(Request $request)
    {
        $vid = str_replace('https://avbebe.com/archives/', '', $request->url);
        $mp4 = "https://v.avgigi.com/acg/watch/{$vid}.mp4";
        $referer = "https://avgigi.com/";
        $opts = [
            'http' => [
               'header' => [
                    "Referer: https://avgigi.com/"
                ]
            ]
        ];
        $context = stream_context_create($opts);
        Storage::disk('local')->put("video/{$vid}.mp4", file_get_contents($mp4, false, $context));
    }

    public function checkHetznerServers()
    {
        $vod_servers = Video::$vod_servers;
        foreach ($vod_servers as $servers) {
            foreach ($servers as $server) {
                $httpcode = Motherless::getHttpcode("https://vdownload-{$server}.hembed.com/");
                echo "vdownload-{$server}.hembed.com returned status code {$httpcode}<br>";

                if ($httpcode != 200 && $httpcode != 0) {
                    Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Hetzner server #'.$server.' failed ('.$httpcode.')', 'master', 'master', "https://vdownload-{$server}.hembed.com/", 'master', 'master'));
                }
            }
        }
    }

    public function getServerSd($balancer, $server, $sd)
    {
        $sd = str_replace("vbalancer-{$balancer}.hembed.com", "vdownload-{$server}.hembed.com", $sd);
        $sd = Helper::sign_hembed_url($sd, env('HEMBED_TOKEN'), 43200);
        return $sd;
    }

    public function getServerQual($balancer, $server, $qualities)
    {
        foreach ($qualities as &$qual) {
            $qual = str_replace("vbalancer-{$balancer}.hembed.com", "vdownload-{$server}.hembed.com", $qual);
            $qual = Helper::sign_hembed_url($qual, env('HEMBED_TOKEN'), 43200);
        }
        return $qualities;
    }

    public function removeAddedTags(Request $request)
    {
        $video = Video::find($request->v);
        if ($tags = $request->tags) {
            $tags_array = $video->tags_array;
            foreach ($tags as $tag) {
                if (array_key_exists($tag, $video->tags_array)) {
                    $tags_array[$tag] = $tags_array[$tag] - 1;
                    if ($tags_array[$tag] <= 0) {
                        unset($tags_array[$tag]);
                    }
                }
            }
            $video->tags_array = $tags_array;
            $video->save();
        }
    }

    public function includeAddedTags(Request $request)
    {
        $video = Video::find($request->v);
        if ($tags = $request->tags) {
            $tags_array = $video->tags_array;
            foreach ($tags as $tag) {
                if (array_key_exists($tag, $video->tags_array)) {
                    $tags_array[$tag] = $tags_array[$tag] + 10;
                } elseif (in_array($tag, Video::$all_tag)) {
                    $tags_array[$tag] = 10;
                }
            }
            $video->tags_array = $tags_array;
            $video->save();
        }
    }

    public function uploadHscangku(Request $request)
    {
        Jav::uploadHscangku($request->pages);
    }

    public function updateEmptySd(Request $request)
    {
        Jav::updateEmptySd();
    }

    public function updateWithMissav(Request $request)
    {
        Jav::updateWithMissav();
    }

    public function updateWithJable(Request $request)
    {
        Jav::updateWithJable();
    }

    public function updateWithAvbebe(Request $request)
    {
        Jav::updateWithAvbebe($request->pages);
    }

    public function uploadHscangkuShirouto(Request $request)
    {
        Jav::uploadHscangkuShirouto($request->pages);
    }

    public function downloadPosters(Request $request)
    {
        Jav::downloadPosters();
    }

    public function updateBlankPosters(Request $request)
    {
        Jav::updateBlankPosters();
    }

    public function updateMissavImgur(Request $request)
    {
        Jav::updateMissavImgur();
    }

    public function checkHscangkuSource(Request $request)
    {
        Jav::checkHscangkuSource($request->link);
    }

    public function imgurToJsdelivr(Request $request)
    {
        $videos = Video::where('cover', 'like', '%imgur%')->orderBy('id', 'desc')->select('id', 'cover', 'imgur')->get()->slice(0, 300);
        foreach ($videos as $video) {
            $cover = str_replace('.png', '.jpg', $video->cover);
            $imgur = Helper::get_string_between($cover, 'https://i.imgur.com/', '.jpg');
            $video->cover = $request->base.$imgur.'.jpg';
            $video->save();
        }
    }

    public function updateShiroutoPlaylist(Request $request)
    {
        $videos = Video::where('playlist_id', 8919)->orderBy('id', 'desc')->limit(150)->get();
        foreach ($videos as $video) {
            $video->playlist_id = $request->id;
            $video->save();
        }
    }

    public function downloadShiroutoImgur(Request $request)
    {
        $videos = Video::where('genre', '國產素人')->where('cover', 'like', '%imgur%')->where('created_at', '<=', '2023-07-11 02:40:23')->orderBy('created_at', 'desc')->select('id', 'cover', 'imgur', 'foreign_sd')->get()->slice(0, 450);

        foreach ($videos as $video) {
            // thumbnail
            $huge = $video->imgur.'h.jpg';
            $large = $video->imgur.'l.jpg';

            if (!file_exists(public_path('shirouto/thumbnail/'.$huge)) || !file_exists(public_path('shirouto/thumbnail/'.$large))) {

                Image::make($video->foreign_sd["poster"])
                    ->fit(1024, 576, function ($constraint) {}, "top")
                    ->save("shirouto/thumbnail/{$huge}", 80);

                Image::make($video->foreign_sd["poster"])
                    ->fit(640, 360, function ($constraint) {}, "top")
                    ->save("shirouto/thumbnail/{$large}", 80);

                /* $url = 'https://i.imgur.com/'.$video->imgur.'.jpg';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_TIMEOUT, '60'); // in seconds
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_NOBODY, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $res = curl_exec($ch);
                if (curl_getinfo($ch)['url'] != $url) {
                    $imgur = '';
                    $cover = '';
                    $imgur_url = $video->foreign_sd["poster"];
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
                    $link = Helper::get_string_between($imgur, 'https://i.imgur.com/', '.');

                    $huge_link = $link.'h.jpg';
                    if (file_put_contents('shirouto/thumbnail/'.$huge, file_get_contents('https://i.imgur.com/'.$huge_link))) {
                        echo 'thumbH '.$huge.' success<br>';
                    } else {
                        echo 'thumbH '.$huge.' failed<br>';
                    }

                    $large_link = $link.'l.jpg';
                    if (file_put_contents('shirouto/thumbnail/'.$large, file_get_contents('https://i.imgur.com/'.$large_link))) {
                        echo 'thumbL '.$large.' success<br>';
                    } else {
                        echo 'thumbL '.$large.' failed<br>';
                    }

                } else {
                    if (file_put_contents('shirouto/thumbnail/'.$huge, file_get_contents('https://i.imgur.com/'.$huge))) {
                        echo 'thumbH '.$huge.' success<br>';
                    } else {
                        echo 'thumbH '.$huge.' failed<br>';
                    }

                    if (file_put_contents('shirouto/thumbnail/'.$large, file_get_contents('https://i.imgur.com/'.$large))) {
                        echo 'thumbL '.$large.' success<br>';
                    } else {
                        echo 'thumbL '.$large.' failed<br>';
                    }
                } */


            } else {
                echo 'Thumbnails exist<br>';
            }
        }
    }

    public function shiroutoImgurToJsdelivr(Request $request)
    {
        $videos = Video::where('genre', '國產素人')->where('cover', 'like', '%imgur%')->orderBy('created_at', 'desc')->select('id', 'cover', 'imgur')->get()->slice(0, 300);
        foreach ($videos as $video) {
            $cover = str_replace('.png', '.jpg', $video->cover);
            $imgur = Helper::get_string_between($cover, 'https://i.imgur.com/', '.jpg');
            $video->cover = "https://cdn.jsdelivr.net/gh/{$request->user}/{$request->user}@v1.0.0/asset/cover/".$imgur.'.jpg';
            $video->save();
        }
    }

    public function downloadFromCdn77(Request $request)
    {
        $url = 'vdownload.hembed.com';
        $expiration = time() + 43200;
        $token = 'xVEO8rLVgGkUBEBg';

        $videos = Video::where('cover', 'like', '%vdownload.hembed.com%')->orderBy('created_at', 'desc')->select('id', 'cover', 'imgur')->get()->slice(0, 300);
        foreach ($videos as $video) {
            // cover
            $file_name = explode('?', str_replace('.png', '.jpg', basename($video->cover)))[0];
            $cover = '/image/cover/'.$file_name;
            if (!file_exists(public_path('cover/'.$file_name))) {
                if (file_put_contents('cover/'.$file_name, file_get_contents(Video::getSignedUrlParameter($url, $cover, $token, $expiration)))) {
                    echo 'cover '.$file_name.' success<br>';
                } else {
                    echo 'cover '.$file_name.' failed<br>';
                }
            } else {
                echo 'cover '.$file_name.' exists<br>';
            }

            // thumbnail
            $huge = $video->imgur.'h.jpg';
            $thumbH = '/image/thumbnail/'.$video->imgur.'h.jpg';
            if (!file_exists(public_path('thumbnail/'.$huge))) {
                if (file_put_contents('thumbnail/'.$huge, file_get_contents(Video::getSignedUrlParameter($url, $thumbH, $token, $expiration)))) {
                    echo 'thumbH '.$huge.' success<br>';
                } else {
                    echo 'thumbH '.$huge.' failed<br>';
                }
            } else {
                echo 'thumbH '.$huge.' exists<br>';
            }

            $large = $video->imgur.'l.jpg';
            $thumbL = '/image/thumbnail/'.$video->imgur.'l.jpg';
            if (!file_exists(public_path('thumbnail/'.$large))) {
                if (file_put_contents('thumbnail/'.$large, file_get_contents(Video::getSignedUrlParameter($url, $thumbL, $token, $expiration)))) {
                    echo 'thumbL '.$large.' success<br>';
                } else {
                    echo 'thumbL '.$large.' failed<br>';
                }
            } else {
                echo 'thumbL '.$large.' exists<br>';
            }
        }
    }

    public function downloadFromImgur(Request $request)
    {
        $videos = Video::where('title', 'like', '%[新番預告]%')->where('cover', 'not like', '%vdownload.hembed.com%')->orderBy('id', 'desc')->select('id', 'cover', 'imgur')->get()->slice(0, 300);
        foreach ($videos as $video) {
            // cover
            $file_name = str_replace('.png', '.jpg', basename($video->cover));
            if (!file_exists(public_path('cover/'.$file_name))) {
                if (file_put_contents('cover/'.$file_name, file_get_contents('https://i.imgur.com/'.$file_name))) {
                    echo 'cover '.$file_name.' success<br>';
                } else {
                    echo 'cover '.$file_name.' failed<br>';
                }
            } else {
                echo 'cover '.$file_name.' exists<br>';
            }

            // thumbnail
            $huge = $video->imgur.'h.jpg';
            if (!file_exists(public_path('thumbnail/'.$huge))) {
                if (file_put_contents('thumbnail/'.$huge, file_get_contents('https://i.imgur.com/'.$huge))) {
                    echo 'thumbH '.$huge.' success<br>';
                } else {
                    echo 'thumbH '.$huge.' failed<br>';
                }
            } else {
                echo 'thumbH '.$huge.' exists<br>';
            }

            $large = $video->imgur.'l.jpg';
            if (!file_exists(public_path('thumbnail/'.$large))) {
                if (file_put_contents('thumbnail/'.$large, file_get_contents('https://i.imgur.com/'.$large))) {
                    echo 'thumbL '.$large.' success<br>';
                } else {
                    echo 'thumbL '.$large.' failed<br>';
                }
            } else {
                echo 'thumbL '.$large.' exists<br>';
            }
        }
    }

    public function downloadFromJsdelivr(Request $request)
    {
        $videos = Video::where('cover', 'like', '%img4.qy0.ru/data/2200/80/%')->orderBy('created_at', 'desc')->select('id', 'cover', 'imgur')->get();
        foreach ($videos as $video) {
            // cover
            $file_name = str_replace('.png', '.jpg', basename($video->cover));
            if (!file_exists(public_path('cover/'.$file_name))) {
                if (file_put_contents('cover/'.$file_name, file_get_contents($video->cover))) {
                    echo 'cover '.$file_name.' success<br>';
                } else {
                    echo 'cover '.$file_name.' failed<br>';
                }
            } else {
                echo 'cover '.$file_name.' exists<br>';
            }

            // thumbnail
            $huge = $video->imgur.'h.jpg';
            if (!file_exists(public_path('thumbnail/'.$huge))) {
                if (file_put_contents('thumbnail/'.$huge, file_get_contents($video->thumbH()))) {
                    echo 'thumbH '.$huge.' success<br>';
                } else {
                    echo 'thumbH '.$huge.' failed<br>';
                }
            } else {
                echo 'thumbH '.$huge.' exists<br>';
            }

            $large = $video->imgur.'l.jpg';
            if (!file_exists(public_path('thumbnail/'.$large))) {
                if (file_put_contents('thumbnail/'.$large, file_get_contents($video->thumbL()))) {
                    echo 'thumbL '.$large.' success<br>';
                } else {
                    echo 'thumbL '.$large.' failed<br>';
                }
            } else {
                echo 'thumbL '.$large.' exists<br>';
            }
        }
    }

    public function updateHomeVideos(Request $request)
    {
        Video_temp::updateHomeVideos();
    }

    public function imageToWnacg(Request $request)
    {
        $videos = Video::where('cover', 'like', '%vdownload.hembed.com%')->orderBy('created_at', 'desc')->select('id', 'cover', 'imgur')->get()->slice(0, 300);
        foreach ($videos as $video) {
            $filename = explode('?', str_replace('.png', '.jpg', basename($video->cover)))[0];
            $video->cover = "{$request->base}".$filename;
            $video->save();
            $video;
        }
    }

    public function imageToCdn77(Request $request)
    {
        $videos = Video::where('title', 'like', '%[新番預告]%')->where('cover', 'not like', '%vdownload.hembed.com%')->orderBy('id', 'desc')->select('id', 'cover', 'imgur')->get()->slice(0, 300);
        foreach ($videos as $video) {
            $filename = substr($video->cover, strrpos($video->cover, '/') + 1);
            $url = 'vdownload.hembed.com';
            $expiration = time() + 43200;
            $token = 'xVEO8rLVgGkUBEBg';
            $source = '/image/cover/'.$filename;
            $video->cover = Video::getSignedUrlParameter($url, $source, $token, $expiration);
            $video->save();
        }
    }
}
