<?php

namespace App;

use App\Video;
use App\Watch;
use Image;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SteelyWing\Chinese\Chinese;
use simplehtmldom\HtmlWeb;
use Spatie\Browsershot\Browsershot;

class Bot extends Model
{
    protected $casts = [
        'data' => 'array'
    ];

	protected $fillable = [
        'id', 'temp', 'data', 'created_at',
    ];

    public static $models = [
        'avatars', 'blogs', 'bots', 'comments', 'likes', 'saves', 'subscribes', 'users', 'videos', 'watches'
    ];

    public static function youtubePre($video_id, $user_id, $playlist_id)
    {
        $bots = Bot::all();
        foreach ($bots as $bot) {
            if ($bot->temp != '') {
                $queries = [];
                parse_str(parse_url($bot->temp, PHP_URL_QUERY), $queries);
                $url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&hl=zh-TW&id='.$queries['v'].'&key=AIzaSyBtjyvczt-3PC9ST3ubWbMTOf5zKddEpuU';
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $data = json_decode(curl_exec($curl_connection), true);
                curl_close($curl_connection);

                $resolution = 'default';
                if (array_key_exists('maxres', $data['items'][0]['snippet']['thumbnails'])) {
                    $resolution = 'maxres';
                } elseif (array_key_exists('standard', $data['items'][0]['snippet']['thumbnails'])) {
                    $resolution = 'standard';
                } elseif (array_key_exists('high', $data['items'][0]['snippet']['thumbnails'])) {
                    $resolution = 'high';
                } elseif (array_key_exists('medium', $data['items'][0]['snippet']['thumbnails'])) {
                    $resolution = 'medium';
                }

                $image = Image::make($data['items'][0]['snippet']['thumbnails'][$resolution]['url']);
                $image = $image->fit(2880, 1620);
                $image = $image->stream();
                $pvars = array('image' => base64_encode($image));
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '932b67e13e4f069'));
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
                $out = curl_exec($curl);
                curl_close ($curl);
                $pms = json_decode($out, true);
                $imgur = $pms['data']['link'];

                if ($imgur != "") {
                    $chinese = new Chinese();
                    Video::create([
                        'id' => $video_id,
                        'user_id' => $user_id,
                        'playlist_id' => $playlist_id,
                        'title' => $chinese->to(Chinese::ZH_HANT, $data['items'][0]['snippet']['localized']['title']),
                        'caption' => $chinese->to(Chinese::ZH_HANT, $data['items'][0]['snippet']['localized']['description']),
                        'sd' => 'https://www.youtube.com/embed/'.$data['items'][0]['id'].'?cc_load_policy=1&cc_lang_pref=zh-Hant&hl=zh_TW&vq=hd1080',
                        'imgur' => Bot::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                        'tags' => array_key_exists('tags', $data['items'][0]['snippet']) ? $chinese->to(Chinese::ZH_HANT, implode(' ', $data['items'][0]['snippet']['tags'])) : '動漫',
                        'views' => 0,
                        'outsource' => true,
                        'created_at' => Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $data['items'][0]['snippet']['publishedAt'])->format('Y-m-d H:i:s'),
                        'uploaded_at' => Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $data['items'][0]['snippet']['publishedAt'])->format('Y-m-d H:i:s'),
                    ]);
                    $bot->delete();
                }

                $video_id++;
            }
        }
    }

    public static function youtubePlaylist($channel_id, $video_id, $user_id, $playlist_id, $tags)
    {
        $url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId='.$channel_id.'&key=AIzaSyBtjyvczt-3PC9ST3ubWbMTOf5zKddEpuU';
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $data = json_decode(curl_exec($curl_connection), true);
        curl_close($curl_connection);

        foreach ($data['items'] as $item) {
            $resolution = 'default';
            if (array_key_exists('maxres', $item['snippet']['thumbnails'])) {
                $resolution = 'maxres';
            } elseif (array_key_exists('standard', $item['snippet']['thumbnails'])) {
                $resolution = 'standard';
            } elseif (array_key_exists('high', $item['snippet']['thumbnails'])) {
                $resolution = 'high';
            } elseif (array_key_exists('medium', $item['snippet']['thumbnails'])) {
                $resolution = 'medium';
            }

            $image = Image::make($item['snippet']['thumbnails'][$resolution]['url']);
            $image = $image->fit(2880, 1620);
            $image = $image->stream();
            $pvars = array('image' => base64_encode($image));
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '932b67e13e4f069'));
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
            $out = curl_exec($curl);
            curl_close ($curl);
            $pms = json_decode($out, true);
            $imgur = $pms['data']['link'];

            if ($imgur != "") {
                $chinese = new Chinese();
                Video::create([
                    'id' => $video_id,
                    'user_id' => $user_id,
                    'playlist_id' => $playlist_id,
                    'title' => $chinese->to(Chinese::ZH_HANT, $item['snippet']['title']),
                    'caption' => $chinese->to(Chinese::ZH_HANT, $item['snippet']['description']),
                    'sd' => 'https://www.youtube.com/embed/'.$item['snippet']['resourceId']['videoId'].'?cc_load_policy=1&cc_lang_pref=zh-Hant&hl=zh_TW&vq=hd1080',
                    'imgur' => Bot::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                    'tags' => $tags,
                    'views' => 0,
                    'outsource' => true,
                    'created_at' => Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $item['snippet']['publishedAt'])->format('Y-m-d H:i:s'),
                    'uploaded_at' => Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $item['snippet']['publishedAt'])->format('Y-m-d H:i:s'),
                ]);
                $video_id++;
            }
        }
    }

    public static function youtube(Bot $bot)
    {
        $channel_id = str_ireplace('https://www.youtube.com/channel/', '', $bot->data['source']);
        $url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId='.$channel_id.'&maxResults=10&order=date&key=AIzaSyBtjyvczt-3PC9ST3ubWbMTOf5zKddEpuU';

        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $data = json_decode(curl_exec($curl_connection), true);
        curl_close($curl_connection);

        foreach ($data['items'] as $item) {
            $video_id = $item['id']['videoId'];
            if (!Video::where('sd', 'ilike', '%'.$video_id.'%')->exists()) {
                $url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&hl=zh-TW&id='.$video_id.'&key=AIzaSyBtjyvczt-3PC9ST3ubWbMTOf5zKddEpuU';
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $data = json_decode(curl_exec($curl_connection), true);
                curl_close($curl_connection);

                $resolution = 'default';
                if (array_key_exists('maxres', $data['items'][0]['snippet']['thumbnails'])) {
                    $resolution = 'maxres';
                } elseif (array_key_exists('standard', $data['items'][0]['snippet']['thumbnails'])) {
                    $resolution = 'standard';
                } elseif (array_key_exists('high', $data['items'][0]['snippet']['thumbnails'])) {
                    $resolution = 'high';
                } elseif (array_key_exists('medium', $data['items'][0]['snippet']['thumbnails'])) {
                    $resolution = 'medium';
                }

                $image = Image::make($data['items'][0]['snippet']['thumbnails'][$resolution]['url']);
                $image = $image->fit(2880, 1620);
                $image = $image->stream();
                $pvars = array('image' => base64_encode($image));
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '932b67e13e4f069'));
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
                $out = curl_exec($curl);
                curl_close ($curl);
                $pms = json_decode($out, true);
                $imgur = $pms['data']['link'];

                if ($imgur != "") {
                    $chinese = new Chinese();
                    $video = Video::create([
                        'user_id' => $bot->data['user_id'],
                        'playlist_id' => $bot->data['playlist_id'],
                        'title' => $chinese->to(Chinese::ZH_HANT, $data['items'][0]['snippet']['localized']['title']),
                        'caption' => $chinese->to(Chinese::ZH_HANT, $data['items'][0]['snippet']['localized']['description']),
                        'sd' => 'https://www.youtube.com/embed/'.$data['items'][0]['id'].'?cc_load_policy=1&cc_lang_pref=zh-Hant&hl=zh_TW&vq=hd1080',
                        'imgur' => Bot::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                        'tags' => array_key_exists('tags', $data['items'][0]['snippet']) ? trim($chinese->to(Chinese::ZH_HANT, implode(' ', $data['items'][0]['snippet']['tags'])).' '.$bot->data['tags']) : $bot->data['tags'],
                        'views' => 0,
                        'outsource' => true,
                        'created_at' => Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $data['items'][0]['snippet']['publishedAt'])->format('Y-m-d H:i:s'),
                        'uploaded_at' => Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $data['items'][0]['snippet']['publishedAt'])->format('Y-m-d H:i:s'),
                    ]);
                    Video::notifySubscribers($video);
                }
            }
        }
    }

    public static function bilibiliPrePre($mid)
    {
        $url = 'https://space.bilibili.com/ajax/member/getSubmitVideos?mid='.$mid;
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $pages = json_decode(curl_exec($curl_connection), true)['data']['pages'];
        curl_close($curl_connection);

        for ($i = 1; $i <= $pages; $i++) { 
            $url = 'https://space.bilibili.com/ajax/member/getSubmitVideos?mid='.$mid.'&page='.$i;
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $data = json_decode(curl_exec($curl_connection), true);
            curl_close($curl_connection);
            foreach ($data['data']['vlist'] as $video) {
                if (!Video::where('sd', 'ilike', '%aid='.$video['aid'].'%')->exists()) {
                    Bot::create([
                        'temp' => $video['aid']
                    ]);
                }
            }
        }
    }

    public static function bilibiliPre($name, $video_id, $user_id, $playlist_id, $tags)
    {
        $bots = Bot::all();
        $chinese = new Chinese();
        foreach ($bots as $bot) {
            if ($bot->temp != '') {
                $url = 'https://api.bilibili.com/x/web-interface/view?aid='.$bot->temp;
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_connection, CURLOPT_HTTPHEADER, [
                    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:56.0) Gecko/20100101 Firefox/56.0',
                    'Host: api.bilibili.com',
                    'Cookie: SESSDATA=33c1bfb1%2C1606096573%2C4f954*51;'
                ]);
                $data = json_decode(curl_exec($curl_connection), true);
                curl_close($curl_connection);

                $title = $chinese->to(Chinese::ZH_HANT, $data['data']['title']);
                $pass = true;
                Bot::setBilibiliConfigs($name, $playlist_id, $title, $tags, $pass);

                if ($pass) {
                    $image = Image::make($data['data']['pic']);
                    $image = $image->fit(2880, 1620);
                    $image = $image->stream();
                    $pvars = array('image' => base64_encode($image));
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
                    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '932b67e13e4f069'));
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
                    $out = curl_exec($curl);
                    curl_close ($curl);
                    $pms = json_decode($out, true);
                    $imgur = $pms['data']['link'];

                    if ($imgur != "") {
                        $video = Video::create([
                            'id' => $video_id,
                            'user_id' => $user_id,
                            'playlist_id' => $playlist_id,
                            'title' => $title,
                            'caption' => $chinese->to(Chinese::ZH_HANT, $data['data']['desc']),
                            'sd' => '//player.bilibili.com/player.html?aid='.$data['data']['aid'].'&bvid='.$data['data']['bvid'].'&cid='.$data['data']['pages'][0]['cid'].'&page=1',
                            'imgur' => Bot::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                            'tags' => $chinese->to(Chinese::ZH_HANT, $tags),
                            'views' => 0,
                            'outsource' => true,
                            'created_at' => date('Y-m-d H:i:s', $data['data']['pubdate']),
                            'uploaded_at' => date('Y-m-d H:i:s', $data['data']['pubdate']),
                        ]);
                        $bot->delete();
                        $video_id++;
                    }
                }
            }
        }
    }

    public static function bilibiliPlaylist($aid, $video_id, $user_id, $playlist_id, $tags)
    {
        $url = 'https://api.bilibili.com/x/web-interface/view?aid='.$aid;
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $data = json_decode(curl_exec($curl_connection), true);
        curl_close($curl_connection);

        $aid = $data['data']['aid'];
        $bvid = $data['data']['bvid'];
        $date = new Carbon(Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', $data['data']['pubdate']))->format('Y-m-d H:i:s'));
        $chinese = new Chinese();
        foreach ($data['data']['pages'] as $video) {
            $title = $video['part'];
            if (strpos($title, '妙国民纠察队') === false) {
                $title = '妙国民纠察队-'.$video['part'];
            }
            $video = Video::create([
                'id' => $video_id,
                'user_id' => $user_id,
                'playlist_id' => $playlist_id,
                'title' => $chinese->to(Chinese::ZH_HANT, $title),
                'caption' => '',
                'sd' => '//player.bilibili.com/player.html?aid='.$aid.'&bvid='.$bvid.'&cid='.$video['cid'].'&page='.$video['page'],
                'imgur' => 'JMcgEkP',
                'tags' => $chinese->to(Chinese::ZH_HANT, $tags),
                'views' => 0,
                'outsource' => true,
                'created_at' => $date,
                'uploaded_at' => $date,
            ]);
            $date = $date->addDays(7);
            $video_id++;
        }
    }

    public static function bilibili(Bot $bot)
    {
        $mid = str_ireplace('https://space.bilibili.com/', '', $bot->data['source']);
        $url = 'https://api.bilibili.com/x/space/arc/search?mid='.$mid.'&ps=30&tid=0&pn=1&keyword=&order=pubdate&jsonp=jsonp';
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $data = json_decode(curl_exec($curl_connection), true);
        curl_close($curl_connection);

        $chinese = new Chinese();
        foreach ($data['data']['list']['vlist'] as $video) {
            $aid = $video['aid'];
            if (!Video::where('sd', 'ilike', '%aid='.$aid.'%')->exists()) {
                $url = 'https://api.bilibili.com/x/web-interface/view?aid='.$aid;
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_connection, CURLOPT_HTTPHEADER, [
                    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:56.0) Gecko/20100101 Firefox/56.0',
                    'Host: api.bilibili.com',
                    'Cookie: SESSDATA=33c1bfb1%2C1606096573%2C4f954*51;'
                ]);
                $data = json_decode(curl_exec($curl_connection), true);
                curl_close($curl_connection);

                $playlist_id = $bot->data['playlist_id'];
                $title = $chinese->to(Chinese::ZH_HANT, $data['data']['title']);
                $tags = $bot->data['tags'];
                $outsource = true;
                $pass = true;
                Bot::setBilibiliConfigs($bot->data['name'], $playlist_id, $title, $tags, $outsource, $pass);

                if ($pass) {
                    $image = Image::make($data['data']['pic']);
                    $image = $image->fit(2880, 1620);
                    $image = $image->stream();
                    $pvars = array('image' => base64_encode($image));
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
                    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '932b67e13e4f069'));
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
                    $out = curl_exec($curl);
                    curl_close ($curl);
                    $pms = json_decode($out, true);
                    $imgur = $pms['data']['link'];

                    if ($imgur != "") {
                        $video = Video::create([
                            'user_id' => $bot->data['user_id'],
                            'playlist_id' => $playlist_id,
                            'title' => $title,
                            'caption' => $chinese->to(Chinese::ZH_HANT, $data['data']['desc']),
                            'sd' => '//player.bilibili.com/player.html?aid='.$data['data']['aid'].'&bvid='.$data['data']['bvid'].'&cid='.$data['data']['pages'][0]['cid'].'&page=1',
                            'imgur' => Bot::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                            'tags' => $chinese->to(Chinese::ZH_HANT, $tags),
                            'views' => 0,
                            'outsource' => $outsource,
                            'created_at' => date('Y-m-d H:i:s', $data['data']['pubdate']),
                            'uploaded_at' => date('Y-m-d H:i:s', $data['data']['pubdate']),
                        ]);
                        Video::notifySubscribers($video);
                    }
                }
            }
        }
    }

    public static function setBilibiliConfigs($name, &$playlist_id, &$title, &$tags, &$outsource, &$pass)
    {
        switch ($name) {
            case '倫敦之心字幕組':
                if (strpos(strtolower($title), 'london hearts') !== false) {
                    $inner = Bot::get_string_between($title, '【', '】');
                    $title = str_replace('【'.$inner.'】', '【男女糾察隊/倫敦之心】', $title);
                    $outsource = false;
                } else {
                    $playlist_id = null;
                    $tags = '綜藝';
                }
                break;

            case 'blueinta':
                if (strpos($title, '有吉君的正直散步') !== false) {
                    $playlist_id = 204;
                    $tags = '有吉弘行 生野陽子 有吉君的正直散步 有吉くんの正直さんぽ 搞笑 旅行 美食 綜藝';
                } elseif (strpos($title, '幸福窮女孩') !== false) {
                    $playlist_id = 215;
                    $tags = '水卜麻美 植松晃士 劇團一人 杉村太蔵 DAIGO 針千本 近藤春菜 箕輪遙 森泉 幸福窮女孩 幸せ!ボンビーガール 窮人 有錢人 真人秀 跟拍 街訪 路人 紀錄片 成長 奮鬥 感動 綜藝';
                } elseif (strpos($title, '日本我來了') !== false) {
                    $playlist_id = 185;
                    $tags = '香蕉人 設樂統 日村勇紀 外國人 老外 跟拍 路人 街訪 日本我來了 YOUは何しに日本へ? 綜藝';
                } elseif (strpos($title, '跟拍到你家') !== false) {
                    $playlist_id = 4;
                    $tags = '驚嚇大木 矢作兼 鷲見玲奈 路人 街訪 感動 跟拍到你家 家、ついて行ってイイですか？ 中文字幕 明星 綜藝';
                } elseif (strpos($title, '新鮮事調查局') !== false) {
                    $playlist_id = 198;
                    $tags = '香蕉人 設樂統 日村勇紀 新鮮事調查局 ソノサキ～知りたい見たいを大追跡!～ 小知識 潮流 調查 明星 綜藝';
                } elseif (strpos($title, '日本太太好吃驚') !== false) {
                    $playlist_id = 250;
                    $tags = '爆笑問題 太田光 田中裕二 大吉洋平 加藤夏希 渡邊滿裡奈 MEGUMI YOU 松嶋尚美 出川哲朗 黛薇夫人 日本太太好吃驚 世界の日本人妻は見た! 旅遊 真人秀 小知識 綜藝';
                } elseif (strpos($title, '移居世界秘境日本人好吃驚') !== false) {
                    $playlist_id = 233;
                    $tags = '千原兄弟 千原Junior 千原靖史 森山良子 高橋南 須賀健太 移居世界秘境日本人好吃驚 世界の村で発見!こんなところに日本人 旅行 真人秀 綜藝';
                } elseif (strpos($title, '全能住宅改造王') !== false) {
                    $playlist_id = 259;
                    $tags = '所喬治 江口朋美 加藤綠 窮人 有錢人 真人秀 小知識 日本房產 全能住宅改造王 大改造!!劇的ビフォーアフター 綜藝';
                } else {
                    $playlist_id = null;
                    $tags = '綜藝';
                }
                break;

            case 'NO GOOD TV':
                if (strpos($title, '【中字】') !== false) {
                    $outsource = false;
                    $title = str_replace('【中字】', '', $title);
                } else {
                    $pass = false;
                }
                break;

            case '秋爸是奶爸':
                if (strpos($title, '【Music Station】') !== false) {
                    $pass = true;
                } else {
                    $pass = false;
                }
                break;

            case '千鳥電視台':
                if (strpos($title, '千鳥電視台') !== false) {
                    $playlist_id = 240;
                    $tags = '千鳥 大悟 阿信 NOBU 高橋茂雄 田中卓志 狩野英孝 小島瑠璃子 中岡創一 千鳥電視台 テレビ千鳥 搞笑 綜藝';
                    $outsource = false;
                    $pass = true;
                } else {
                    $pass = false;
                }
                break;

            case '村上信五補給站':
                if (strpos($title, '請聽村上黑美吐槽') !== false) {
                    $title = str_replace('請聽村上黑美吐槽', '村上美乃滋的請讓我吐槽', $title);
                    $outsource = false;
                    $pass = true;
                } else {
                    $pass = false;
                }
                break;

            case '反正不是字幕組':
                if (strpos($title, '關西鐵漢們的成長記錄') !== false) {
                    $playlist_id = 242;
                    $title = str_replace('關西鐵漢們的成長記錄', '關八編年史', $title);
                    $tags = '關西傑尼斯8 關8 橫山裕 村上信五 丸山隆平 錦戶亮 安田章大 大倉忠義 內博貴 澀谷昴 關八編年史 関ジャニ∞クロニクル 搞笑 明星 挑戰 綜藝';
                    $outsource = false;
                } else {
                    $playlist_id = null;
                    $tags = '綜藝';
                }
                break;

            case '二宮先生':
                if (strpos($title, '【小和組】加倍寵尼') !== false) {
                    $title = str_replace('【小和組】加倍寵尼', '二宮先生', $title);
                    $outsource = false;
                    $pass = true;
                } else {
                    $pass = false;
                }
                break;

            case '千葉名產保護組':
                if (strpos($title, '【動物世界】【字】') !== false) {
                    $playlist_id = 223;
                    $title = str_replace('【動物世界】【字】', '天才！志村動物園 ', $title);
                    $tags = '志村健 相葉雅紀 嵐Arashi 山瀨麻美 小崇小敏 DAIGO 針千本 近藤春菜 箕輪遙 動物 寵物 可愛 貓咪 狗狗 喵星人 汪星人 感動 搞笑 天才！志村動物園 天才!志村どうぶつ園 綜藝';
                    $outsource = false;
                } elseif (strpos($title, '【農廣天地】【字】') !== false) {
                    $playlist_id = 216;
                    $title = str_replace('【農廣天地】【字】', '相葉愛學習 ', $title);
                    $tags = '相葉雅紀 嵐Arashi 高橋茂雄 Unjash 渡邊健 原市 澤部佑 小知識 美食 料理 學習 教育 旅行 搞笑 明星 相葉愛學習 相葉マナブ 綜藝';
                    $outsource = false;
                } else {
                    $playlist_id = null;
                    $tags = '綜藝';
                }
                break;

            case '千葉幽羽':
                if (strpos($title, '乃木坂工事中') !== false) {
                    $playlist_id = 152;
                    $tags = '乃木坂46 秋元真夏 岩本蓮加 梅澤美波 遠藤さくら 大園桃子 賀喜遥香 久保史緒里 齋藤飛鳥 白石麻衣 新内眞衣 清宮レイ 高山一実 筒井あやめ 中田花奈 樋口日奈 星野みなみ 堀未央奈 松村沙友理 山下美月 与田祐希 和田まあや 乃木坂工事中 香蕉人 明星 搞笑 女子偶像團體 綜藝';
                    $outsource = false;
                    $pass = true;
                } else {
                    $pass = false;
                }
                break;

            case 'SHOS字幕组':
                if (strpos($title, '【周四晚與小櫻約會】') !== false) {
                    $playlist_id = 75;
                    $title = str_replace('【周四晚與小櫻約會】', '櫻井有吉的危險夜會 ', $title);
                    $tags = '櫻井翔 嵐Arashi 有吉弘行 明星 訪談 搞笑 櫻井有吉的危險夜會 櫻井有吉アブナイ夜會 綜藝';
                    $outsource = false;
                } else {
                    $playlist_id = null;
                    $tags = '綜藝';
                }
                break;

            case 'Aloha':
                if (strpos($title, '【字】土曜團建日') !== false) {
                    $playlist_id = 76;
                    $title = str_replace('【字】土曜團建日', '交給嵐吧/嵐的大挑戰', $title);
                    $tags = '嵐Arashi 大野智 櫻井翔 相葉雅紀 松本潤 二宫和也 嵐的大挑戰 交給嵐吧 嵐にしやがれ 明星 搞笑 競賽 美食 MJ俱樂部 綜藝';
                    $outsource = false;
                } else {
                    $playlist_id = null;
                    $tags = '綜藝';
                }
                break;

            case '豬豬搬運工':
                if (strpos($title, '人間觀察') !== false) {
                    $playlist_id = 2;
                    $inner = Bot::get_string_between($title, '【', '綜藝】');
                    $title = str_replace('【'.$inner.'綜藝】', '', $title);
                    $title = str_replace('人間觀察', ' 人類觀察', $title);
                    $title = substr_replace(substr_replace($title, '.', 4, 0), '.', 7, 0);
                    $tags = '黑色美乃滋 小杉龍一 吉田敬 小泉孝太郎 笹野高史 木下優樹菜 千針本 近藤春菜 箕輪遙 NAOTO 人類觀察 Monitoring ニンゲン観察バラエティモニタリング 爆笑監視中 搞笑 整人 整蠱 綜藝';
                    $outsource = false;
                    $pass = true;
                } else {
                    $pass = false;
                }
                break;

            case '空靈雨跡':
                if (strpos($title, 'WEB動畫') !== false) {
                    $tags = 'WEB動畫 原創動畫 動漫';
                    $outsource = false;
                } elseif (strpos($title, '動畫廣告') !== false) {
                    $tags = '動畫廣告 原創動畫 動漫';
                    $outsource = false;
                } else {
                    $pass = false;
                }
                break;

            case 'Sunday動漫館':
                $outsource = false;
                break;
        }
    }

    public static function agefans(Bot $bot)
    {
        $requests = Browsershot::url($bot->data['source'])
            ->useCookies(['username' => 'admin'])
            ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
            ->triggeredRequests();

        foreach ($requests as $request) {
            if (strpos($request['url'], 'https://www.agefans.tv/age/player/') !== false && strpos($request['url'], 'https://gss3.baidu.com/') !== false) {

                $link = 'https://gss3.baidu.com/'.Bot::get_string_between($request['url'], 'https://gss3.baidu.com/', '.mp4').'.mp4';
                $imgur = Bot::uploadUrlImage($bot->data['imgur']);
                if ($imgur != "" && !Video::where('sd', 'ilike', '%'.$link.'%')->exists()) {
                    $video = Video::create([
                        'user_id' => $bot->data['user_id'],
                        'playlist_id' => $bot->data['playlist_id'],
                        'title' => $bot->data['title'],
                        'caption' => $bot->data['caption'],
                        'sd' => $request['url'],
                        'imgur' => Bot::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                        'tags' => $bot->data['tags'],
                        'views' => 0,
                        'outsource' => true,
                        'created_at' => Carbon::now(),
                        'uploaded_at' => Carbon::now(),
                    ]);
                    Video::notifySubscribers($video);
                    Bot::updateAgefans($bot);
                }

            } elseif (strpos($request['url'], 'https://www.agefans.tv/age/player/') === false && strpos($request['url'], '1098_') !== false) {

                $link = '1098_'.Bot::get_string_between($request['url'], '1098_', '.f0.mp4');
                $imgur = Bot::uploadUrlImage($bot->data['imgur']);
                if ($imgur != "" && !Video::where('sd', 'ilike', '%'.$link.'%')->exists()) {
                    $video = Video::create([
                        'user_id' => $bot->data['user_id'],
                        'playlist_id' => $bot->data['playlist_id'],
                        'title' => $bot->data['title'],
                        'caption' => $bot->data['caption'],
                        'sd' => 'https://www.agefans.tv/age/player/ckx1/?url='.urlencode(Video::getSourceQQ("https://quan.qq.com/video/".$link)),
                        'imgur' => Bot::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                        'tags' => $bot->data['tags'],
                        'views' => 0,
                        'outsource' => true,
                        'created_at' => Carbon::now(),
                        'uploaded_at' => Carbon::now(),
                    ]);
                    Video::notifySubscribers($video);
                    Bot::updateAgefans($bot);
                }

            } elseif (strpos($request['url'], 'https://www.agefans.tv/age/player/') !== false && strpos($request['url'], 'myqcloud.com') !== false) {
                
                $link = $request['url'];
                $imgur = Bot::uploadUrlImage($bot->data['imgur']);
                if ($imgur != "" && !Video::where('sd', 'ilike', '%'.$link.'%')->exists()) {
                    $video = Video::create([
                        'user_id' => $bot->data['user_id'],
                        'playlist_id' => $bot->data['playlist_id'],
                        'title' => $bot->data['title'],
                        'caption' => $bot->data['caption'],
                        'sd' => $request['url'],
                        'imgur' => Bot::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                        'tags' => $bot->data['tags'],
                        'views' => 0,
                        'outsource' => true,
                        'created_at' => Carbon::now(),
                        'uploaded_at' => Carbon::now(),
                    ]);
                    Video::notifySubscribers($video);
                    Bot::updateAgefans($bot);
                }
            }
        }
    }

    public static function yongjiu(String $url)
    {
        $chinese = new Chinese();
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($curl_connection);
        curl_close($curl_connection);

        $start = explode('<!--影片列表开始-->', $html);
        $end = explode('<!--影片列表结束-->' , $start[1]);
        $list = $end[0];

        $dom = new \DOMDocument();
        $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$list);
        $links = $dom->getElementsByTagName('a');
        foreach ($links as $link) {
            $link = $link->getAttribute('href');
            if ($link != '/?m=vod-type-id-14.html') {
                $url = 'http://www.yongjiuzy5.com'.$link;
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $content = curl_exec($curl_connection);
                curl_close($curl_connection);
                $start = explode('<!--火车头地址开始<li>', $content);
                $end = explode('</li>火车头地址结束-->' , $start[1]);
                $snippet = explode('</li><li>', $end[0]);
                for ($i = 0; $i < count($snippet); $i++) { 
                    if (strpos($snippet[$i], '.m3u8') !== false) {
                       array_splice($snippet, $i, 1);
                       $i--;
                    }
                }

                $start = explode('<!--片名开始-->', $content);
                $end = explode('<!--片名结束-->' , $start[1]);
                $title_short = $title_long = $chinese->to(Chinese::ZH_HANT, explode('</li><li>', $end[0])[0]);
                $start = explode('<!--别名开始-->', $content);
                $end = explode('<!--别名结束-->' , $start[1]);
                $title_nickname = $chinese->to(Chinese::ZH_HANT, explode('</li><li>', $end[0])[0]);
                if ($title_nickname != '') {
                    $title_long = $title_short.'/'.$title_nickname;
                }
                if ($watch = Watch::where('title', 'ilike', '%'.$title_short.'%')->orderBy('created_at', 'desc')->first()) {
                    $playlist_id = $watch->id;
                } else {
                    $start = explode('<!--简介开始-->', $content);
                    $end = explode('<!--简介结束-->' , $start[1]);
                    $description = $chinese->to(Chinese::ZH_HANT, explode('</li><li>', $end[0])[0]);
                    $watch = Watch::create([
                        'user_id' => 750,
                        'title' => $title_long,
                        'description' => $description,
                    ]);
                    $playlist_id = $watch->id;
                }

                $date = Carbon::now();
                foreach ($snippet as $line) {
                    $data = explode('$', $line);
                    $episode = $chinese->to(Chinese::ZH_HANT, $data[0]);
                    $link = $data[1];
                    if (!Video::where('playlist_id', $playlist_id)->where('title', 'ilike', '%'.$episode.'%')->exists()) {

                        $screenshot = Browsershot::url($link)
                            ->windowSize(1920, 1080)
                            ->setOption('addStyleTag', json_encode(['content' => '.dplayer-controller,.dplayer-controller-mask{ display: none; }']))
                            ->waitUntilNetworkIdle()
                            ->screenshot();
                        $image = Image::make($screenshot);
                        $image = $image->crop(1440, 1080);
                        $image = $image->resize(1920, null);
                        $image = $image->fit(2880, 1620);
                        $image = $image->stream();
                        $pvars = array('image' => base64_encode($image));
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
                        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '932b67e13e4f069'));
                        curl_setopt($curl, CURLOPT_POST, 1);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
                        $out = curl_exec($curl);
                        curl_close ($curl);
                        $pms = json_decode($out, true);
                        $imgur = $pms['data']['link'];

                        if ($imgur != "") {
                            if ($first = Video::where('playlist_id', $playlist_id)->first()) {
                                $video = Video::create([
                                    'user_id' => $first->user_id,
                                    'playlist_id' => $first->playlist_id,
                                    'title' => explode('【', $first->title)[0].'【'.$episode.'】',
                                    'caption' => explode('【', $first->title)[0].'【'.$episode.'】',
                                    'sd' => $link,
                                    'imgur' => Bot::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                                    'tags' => $first->tags,
                                    'views' => 0,
                                    'outsource' => true,
                                    'created_at' => $date,
                                    'uploaded_at' => $date,
                                ]);
                            } else {
                                $video = Video::create([
                                    'user_id' => 750,
                                    'playlist_id' => $playlist_id,
                                    'title' => $title_long.'【'.$episode.'】',
                                    'caption' => $title_long.'【'.$episode.'】',
                                    'sd' => $link,
                                    'imgur' => Bot::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                                    'tags' => str_replace('/', ' ', $title_long).' 日劇 線上看 中文字幕',
                                    'views' => 0,
                                    'outsource' => true,
                                    'created_at' => $date,
                                    'uploaded_at' => $date,
                                ]);
                            }
                            $date = $date->addSeconds(1);
                            Video::notifySubscribers($video);
                        }
                    }
                }
            }
        }
    }

    public static function updateAgefans(Bot $bot)
    {
        $current = Bot::get_string_between($bot->data['title'], '【第', '話】');
        $next = $current + 1;
        $title = str_replace('【第'.$current.'話】', '【第'.$next.'話】', $bot->data['title']);
        $next = $next < 10 ? '0'.$next : $next;
        $caption = str_replace('【第'.$current.'話】', '【第'.$next.'話】', $bot->data['title']);

        $url = explode('?', $bot->data['source'])[0];
        $query = explode('?', $bot->data['source'])[1];
        $playlist = explode('_', $query)[0];
        $episode = explode('_', $query)[1];
        $source = $url.'?'.$playlist.'_'.($episode + 1);

        $bot->data = [
            'name' => $bot->data['name'],
            'tags' => $bot->data['tags'],
            'imgur' => 'https://i.imgur.com/JJPMK1A.jpg',
            'title' => $title,
            'source' => $source,
            'caption' => $caption,
            'user_id' => $bot->data['user_id'],
            'playlist_id' => $bot->data['playlist_id'],
        ];
        $bot->save();
        return $bot;
    }

    public static function uploadUrlImage(String $url)
    {
        $image = Image::make($url);
        $image = $image->fit(2880, 1620);
        $image = $image->stream();
        $pvars = array('image' => base64_encode($image));
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '932b67e13e4f069'));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
        $out = curl_exec($curl);
        curl_close ($curl);
        $pms = json_decode($out, true);
        return $pms['data']['link'];
    }

    public static function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
