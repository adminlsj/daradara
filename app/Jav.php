<?php

namespace App;

use Mail;
use App\Video;
use App\Helper;
use App\User;
use Carbon\Carbon;
use App\Mail\UserReport;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;
use App\Spankbang;
use Image;
use SteelyWing\Chinese\Chinese;
use Redirect;

class Jav
{
    public static $base = "http://576hsck.cc";

    public static function uploadHscangku($pages = 10)
    {
        Log::info('Hscangku upload started...');

        $chinese = new Chinese();
        for ($i = 1; $i <= $pages; $i++) { 
            $base = Jav::$base;
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
                $code = explode(' ', $title)[0];
                if (Video::where('foreign_sd', 'ilike', '%'.$original_link.'%')->exists()) {
                    Log::info('Hscangku update CODE#'.$code.' imported at '.$original_link);
                } elseif (Video::where('title', 'ilike', $code.' %')->exists()) {
                    Log::alert('Hscangku update CODE#'.$code.' exists at '.$original_link);
                } else {
                    $imgur = "https://i.imgur.com/Ku2VhgD.jpg";
                    $cover = "https://i.imgur.com/E6mSQA2.jpg";
                    $foreign_sd = ['cover' => Helper::get_string_between($cover, 'https://i.imgur.com/', '.'), 'thumbnail' => Helper::get_string_between($imgur, 'https://i.imgur.com/', '.'), 'hscangku' => $original_link];
                    $video = Video::create([
                        'user_id' => 1,
                        'playlist_id' => 8876,
                        'title' => strtoupper($title),
                        'translations' => ['JP' => strtoupper($title)],
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

                    Log::info('Hscangku update ID#'.$video->id.' success...');
                    sleep(10);
                }
            }
        }

        Log::info('Hscangku upload ended...');
    }

    public static function updateEmptySd()
    {
        Log::info('Empty sd update started...');

        $base = Jav::$base;
        $videos = Video::where('foreign_sd', 'like', '%"hscangku"%')
                    ->where('sd', '')
                    ->orderBy('id', 'asc')
                    ->get();

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

            sleep(10);
        }

        Log::info('Empty sd update ended...');
    }

    public static function updateWithMissav()
    {
        Log::info('Missav update started...');

        $videos = Video::whereIn('genre', Video::$genre_jav)
                    ->where('user_id', 1)
                    ->where('created_at', '2000-01-01 00:00:00')
                    ->where('foreign_sd', 'not like', '%"missav"%')
                    ->orderBy('id', 'asc')
                    ->get();

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
                if (strpos($brand, "SOD") !== false) {
                    $brand = 'SOD Create';
                }
                if (strpos($brand, "S1") !== false) {
                    $brand = 'S1 NO.1 STYLE';
                }
                if ($video->caption == '' || $video->caption == null) {
                    $caption = trim(Helper::get_string_between($missav_html, 'line-clamp-2">', '</div>'));
                    $video->caption = $caption;
                }

                $user_id = 1;
                if ($related = Video::where('artist', $brand)->first()) {
                    $user_id = $related->user_id;
                }
                if (strpos($missav_html, "系列:</span>") !== false) {
                    $title = trim(explode('>', Helper::get_string_between($missav_html, '系列:</span>', '</a>'))[1]);
                    if ($watch = Watch::where('title', $title)->first()) {
                        $video->playlist_id = $watch->id;
                        $video->user_id = $watch->user_id;
                        $video->artist = User::find($watch->user_id)->name;
                    } else {
                        $watch = Watch::create([
                            'user_id' => $user_id,
                            'title' => $title,
                            'description' => $title,
                        ]);
                        $video->playlist_id = $watch->id;
                        $video->user_id = $watch->user_id;
                        $video->artist = User::find($watch->user_id)->name;
                    }

                } elseif (strpos($missav_html, "標籤:</span>") !== false) {
                    $tag = trim(explode('>', Helper::get_string_between($missav_html, '標籤:</span>', '</a>'))[1]);
                    if ($tag_watch = Watch::where('title', $tag)->first()) {
                        $video->playlist_id = $tag_watch->id;
                        $video->user_id = $tag_watch->user_id;
                        $video->artist = User::find($tag_watch->user_id)->name;
                    } else {
                        $tag_watch = Watch::create([
                            'user_id' => $user_id,
                            'title' => $tag,
                            'description' => $tag,
                        ]);
                        $video->playlist_id = $tag_watch->id;
                        $video->user_id = $tag_watch->user_id;
                        $video->artist = User::find($tag_watch->user_id)->name;
                    }
                }

                $video->translations = ['JP' => $title_jp];
                $video->downloads = ['720' => $downloads];
                $video->artist = $brand;
                $video->created_at = $created_at;
                $video->uploaded_at = $created_at;

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

                $video->imgur = Helper::get_string_between($imgur, 'https://i.imgur.com/', '.');
                $temp = $video->foreign_sd;
                $temp['cover'] = Helper::get_string_between($cover, 'https://i.imgur.com/', '.');
                $temp['thumbnail'] = Helper::get_string_between($imgur, 'https://i.imgur.com/', '.');
                $temp['characters'] = implode(',', $characters);
                $temp['missav'] = $missav_link;
                $video->foreign_sd = $temp;
                $video->uploaded_at = Carbon::now()->toDateTimeString();
                $video->save();

                Log::info('Missav update ID#'.$video->id.' success...');
            }

            sleep(10);
        }

        Log::info('Missav update ended...');
    }

    public static function updateWithJable()
    {
        Log::info('Jable update started...');

        $videos = Video::whereIn('genre', Video::$genre_jav)
                    ->where('foreign_sd', 'not like', '%"jable"%')
                    ->orderBy('id', 'asc')
                    ->get();

        foreach ($videos as $video) {
            $code = strtolower(trim(explode(' ', $video->title)[0]));
            $jable_url = "https://jable.tv/videos/{$code}/";
            $jable_html = Browsershot::url($jable_url)
                ->timeout(10)
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

                Log::info('Jable update ID#'.$video->id.' success...');

            } else {
                $temp = $video->foreign_sd;
                $temp['jable'] = '404';
                $video->foreign_sd = $temp;
                $video->save();

                Log::info('Jable update ID#'.$video->id.' failed...');
            }
        }

        Log::info('Jable update ended...');
    }

    public static function updateWithAvbebe($pages = 1)
    {
        Log::info('Avbebe update started...');

        for ($i = 1; $i <= $pages; $i++) { 
            $page_url = "https://avbebe.com/archives/category/%E7%B6%9C%E5%90%88av/%E7%B6%9C%E5%90%88av-%E4%B8%AD%E6%96%87%E5%AD%97%E5%B9%95";
            if ($i > 1) {
                $page_url = "https://avbebe.com/archives/category/%E7%B6%9C%E5%90%88av/%E7%B6%9C%E5%90%88av-%E4%B8%AD%E6%96%87%E5%AD%97%E5%B9%95/page/{$i}";
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

                    $title = trim(Helper::get_string_between($avbebe_html, '】', ' &#8211; Avbebe.com 高清H動畫♥沒有片頭廣告♥最新里番'));
                    $userInteractionCount = Helper::get_string_between($avbebe_html, '"userInteractionCount":', '}}</script>');
                    $caption = trim(Helper::get_string_between($avbebe_html, 'userInteractionCount":'.$userInteractionCount.'}}</script>', '</div>'));
                    $sd = trim(Helper::get_string_between($avbebe_html, 'type="application/x-mpegurl" src="', '"'));

                    $code = trim(explode(' ', $title)[0]);
                    if ($video = Video::where('title', 'ilike', $code.'%')->first()) {
                        $video->title = $title;
                        if ($caption != '') {
                            $video->caption = $caption;
                        } else {
                            Log::info('Avbebe update ID#'.$video->id.' empty caption '.$avbebe_link.'...');
                        }
                        $temp = $video->foreign_sd;
                        $temp["avbebe"] = $avbebe_link;
                        $video->foreign_sd = $temp;
                        $video->save();
                        Log::info('Avbebe update ID#'.$video->id.' with '.$avbebe_link.'...');

                        if ($video->sd != $sd) {
                            Log::info('Avbebe update ID#'.$video->id.' sd different from '.$avbebe_link.'...');
                        }
                    }

                } else {
                    Log::info('Avbebe update '.$avbebe_link.' already exists...');
                }
            }
        }

        Log::info('Avbebe update ended...');
    }

    public static function uploadHscangkuShirouto($pages = 10)
    {
        Log::info('Hscangku shirouto upload started...');

        $chinese = new Chinese();
        for ($i = 10; $i <= $pages; $i++) { 
            $base = Jav::$base;
            $page_url = "{$base}/vodtype/15-{$i}.html";

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
            $poster_links = [];
            foreach ($page_links_raw as $page_link_raw) {
                $original = $page_link_raw;
                $title = $chinese->to(Chinese::ZH_HANT, Helper::get_string_between($page_link_raw, 'title="', '"'));
                $page_link_raw = Helper::get_string_between($page_link_raw, '/', '"');
                if (!array_key_exists($page_link_raw, $page_links)) {
                    $page_links[$page_link_raw] = $title;
                    $poster_links[$page_link_raw.'_poster'] = Helper::get_string_between($original, 'data-original="', '"');
                }
            }
            foreach ($page_links as $hscangku_link => $title) {
                $original_link = "/vodplay/{$hscangku_link}";
                $code = explode(' ', $title)[0];
                if (Video::where('foreign_sd', 'ilike', '%'.$original_link.'%')->exists()) {
                    Log::info('Hscangku shirouto update CODE#'.$code.' imported at '.$original_link);
                } elseif (Video::where('title', 'ilike', $code.' %')->exists()) {
                    Log::alert('Hscangku shirouto update CODE#'.$code.' exists at '.$original_link);
                } else {
                    /* $imgur = '';
                    $cover = '';
                    $imgur_url = $poster_links[$hscangku_link.'_poster'];
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
                    $imgur = $pms['data']['link']; */

                    $imgur = 'https://i.imgur.com/Ku2VhgD.jpg';
                    $poster = $poster_links[$hscangku_link.'_poster'];
                    $created_at = explode('/', Helper::get_string_between($poster, 'images/', '.'));
                    array_pop($created_at);
                    $created_at = implode('-', $created_at).' '.Carbon::now()->toTimeString();
                    $foreign_sd = ['hscangku' => $original_link, 'poster' => $poster];
                    $video = Video::create([
                        // HSCK user_id = 575858
                        'user_id' => 575858,
                        'playlist_id' => 8919,
                        'title' => strtoupper($title),
                        'translations' => ['JP' => strtoupper($title)],
                        'caption' => '',
                        'sd' => '',
                        'imgur' => Helper::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                        'tags' => '素人',
                        'tags_array' => ['素人' => 100],
                        'artist' => 'HSCK',
                        'genre' => '國產素人',
                        'views' => 0,
                        'outsource' => false,
                        'created_at' => $created_at,
                        'uploaded_at' => Carbon::now()->toDateTimeString(),
                        'foreign_sd' => $foreign_sd,
                        'cover' => 'https://i.imgur.com/E6mSQA2.jpg',
                        'uncover' => true,
                    ]);

                    Log::info('Hscangku shirouto update ID#'.$video->id.' success...');
                    sleep(10);
                }
            }
        }

        Log::info('Hscangku shirouto upload ended...');
    }

    public static function updateBlankPosters()
    {
        Log::info('Blank posters update started...');

        $videos = Video::where('imgur', 'Ku2VhgD')->where('foreign_sd', 'ilike', '%"poster"%')->orderBy('id', 'asc')->get();
        foreach ($videos as $video) {
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

            $video->imgur = Helper::get_string_between($imgur, 'https://i.imgur.com/', '.');
            $video->save();

            Log::info('Blank posters update ID#'.$video->id.' success...');
        }

        Log::info('Blank posters update ended...');
    }
}