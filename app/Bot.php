<?php

namespace App;

use App\Video;
use Image;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SteelyWing\Chinese\Chinese;

class Bot extends Model
{
    protected $casts = [
        'data' => 'array'
    ];

	protected $fillable = [
        'id', 'temp', 'data', 'created_at',
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
                    Video::create([
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
                Bot::create([
                    'temp' => $video['aid']
                ]);
            }
        }
    }

    public static function bilibiliPre($video_id, $user_id, $playlist_id)
    {
        $bots = Bot::all();
        foreach ($bots as $bot) {
            if ($bot->temp != '') {
                $url = 'https://api.bilibili.com/x/web-interface/view?aid='.$bot->temp;
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $data = json_decode(curl_exec($curl_connection), true);
                curl_close($curl_connection);

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
                    $name = '倫敦之心字幕組';
                    $chinese = new Chinese();
                    $video = Video::create([
                        'id' => $video_id,
                        'user_id' => $user_id,
                        'playlist_id' => Bot::getPlaylistId($name, $data['data']['title'], $playlist_id),
                        'title' => $chinese->to(Chinese::ZH_HANT, Bot::getTitle($name, $data['data']['title'])),
                        'caption' => $chinese->to(Chinese::ZH_HANT, $data['data']['desc']),
                        'sd' => '//player.bilibili.com/player.html?aid='.$data['data']['aid'].'&bvid='.$data['data']['bvid'].'&cid='.$data['data']['pages'][0]['cid'].'&page=1',
                        'imgur' => Bot::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                        'tags' => $chinese->to(Chinese::ZH_HANT, Bot::getTags($name, $data['data']['title'])),
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

    public static function bilibili(Bot $bot)
    {
        $mid = str_ireplace('https://space.bilibili.com/', '', $bot->data['source']);
        $url = 'https://space.bilibili.com/ajax/member/getSubmitVideos?mid='.$mid;
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $data = json_decode(curl_exec($curl_connection), true);
        curl_close($curl_connection);

        foreach ($data['data']['vlist'] as $video) {
            $aid = $video['aid'];
            if (!Video::where('sd', 'ilike', '%aid='.$aid.'%')->exists()) {
                $url = 'https://api.bilibili.com/x/web-interface/view?aid='.$aid;
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $data = json_decode(curl_exec($curl_connection), true);
                curl_close($curl_connection);

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
                    $playlist_id = $bot->data['playlist_id'];
                    $title = $data['data']['title'];
                    $tags = $bot->data['tags'];
                    Bot::setBilibiliConfigs($bot->data['name'], $playlist_id, $title, $tags);

                    $chinese = new Chinese();
                    Video::create([
                        'user_id' => $bot->data['user_id'],
                        'playlist_id' => $playlist_id,
                        'title' => $chinese->to(Chinese::ZH_HANT, $title),
                        'caption' => $chinese->to(Chinese::ZH_HANT, $data['data']['desc']),
                        'sd' => '//player.bilibili.com/player.html?aid='.$data['data']['aid'].'&bvid='.$data['data']['bvid'].'&cid='.$data['data']['pages'][0]['cid'].'&page=1',
                        'imgur' => Bot::get_string_between($imgur, 'https://i.imgur.com/', '.'),
                        'tags' => $chinese->to(Chinese::ZH_HANT, $tags),
                        'views' => 0,
                        'outsource' => true,
                        'created_at' => date('Y-m-d H:i:s', $data['data']['pubdate']),
                        'uploaded_at' => date('Y-m-d H:i:s', $data['data']['pubdate']),
                    ]);
                }
            }
        }
    }

    public static function setBilibiliConfigs($name, &$playlist_id, &$title, &$tags)
    {
        switch ($name) {
            case '倫敦之心字幕組':
                if (strpos(strtolower($title), 'london hearts') !== false) {
                    $inner = Bot::get_string_between($title, '【', '】');
                    $title = str_replace('【'.$inner.'】', '【男女糾察隊/倫敦之心】', $title);
                } else {
                    $playlist_id = null;
                    $tags = '綜藝';
                }
                break;
        }
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
