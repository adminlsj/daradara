<?php

namespace App\Http\Controllers;

use App\Video;
use App\Bot;
use App\Watch;
use App\Subscribe;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Response;
use Auth;
use Image;
use SteelyWing\Chinese\Chinese;
use Redirect;
use simplehtmldom\HtmlWeb;
use Spatie\Browsershot\Browsershot;

class BotController extends Controller
{
    public function youtubePre(Request $request)
    {
        $video_id = 8555;
        $user_id = 9318;
        $playlist_id = 749;
        Bot::youtubePre($video_id, $user_id, $playlist_id);
    }

    public function youtubePlaylist(Request $request)
    {
        $channel_id = 'PL12UaAf_xzfpKB3uUvYYbxg3UBOxBZfDl';
        $video_id = 8778;
        $user_id = 5190;
        $playlist_id = 752;
        $tags = '冰菓 冰果 氷菓 古籍研究社系列 正版動漫 動漫 線上看 中文字幕';
        Bot::youtubePlaylist($channel_id, $video_id, $user_id, $playlist_id, $tags);
    }

    public function bilibiliPrePre(Request $request)
    {
        $mid = 129426196;
        Bot::bilibiliPrePre($mid);
    }

    public function bilibiliPre(Request $request)
    {
        $video_id = 9361;
        $user_id = 365;
        $playlist_id = 148;
        $tags = '嵐Arashi 大野智 櫻井翔 相葉雅紀 二宮和也 松本潤 VS嵐 嵐的大運動會 搞笑 運動 競賽 明星 綜藝';
        Bot::bilibiliPre('VS嵐', $video_id, $user_id, $playlist_id, $tags);
    }

    public function bilibiliPlaylist(Request $request)
    {
        $aid = '10990791';
        $video_id = 8801;
        $user_id = 406;
        $playlist_id = 217;
        $tags = '三野文泰 久本雅美 妙國民糾察隊 日本大國民 日本妙國民 秘密のケンミンSHOW 縣民 地域戰 小知識 美食 料理 學習 教育 旅行 文化 搞笑 綜藝';
        Bot::bilibiliPlaylist($aid, $video_id, $user_id, $playlist_id, $tags);
    }

    public function uploadVideos(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $bots = Bot::all();
            foreach ($bots as $bot) {
                switch (str_ireplace('www.', '', parse_url($bot->data['source'], PHP_URL_HOST))) {
                    case 'youtube.com':
                        Bot::youtube($bot);
                        break;

                    case 'space.bilibili.com':
                        Bot::bilibili($bot);
                        break;
                }
            }
        }
    }

    public function uploadAgefans(Request $request)
    {
        $curl_connection = curl_init('https://www.agefans.tv/update');
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $content = curl_exec($curl_connection);
        curl_close($curl_connection);
        $link = 'https://www.agefans.tv'.Bot::get_string_between(explode('</h4>', explode('<h4 class="anime_icon2_name">', $content)[1])[0], '<a href="', '">');

        $bots = Bot::where('temp', $link)->get();
        foreach ($bots as $bot) {
            Bot::agefans($bot);
        }
    }

    public function updateHentai(Request $request)
    {
        $videos = Video::where('tags', 'ilike', '%裏番%')->where('foreign_sd', '!=', null)->get();
        foreach ($videos as $video) {
            if (array_key_exists('slutload', $video->foreign_sd)) {
                $requests = Browsershot::url($video->foreign_sd['slutload'])
                    ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                    ->triggeredRequests();
                foreach ($requests as $request) {
                    if (strpos($request['url'], 'https://v-rn.slutload-media.com/') !== false && strpos($request['url'], '.mp4') !== false) {
                        $video->sd = $request['url'];
                        $video->outsource = false;
                        $video->save();
                    }
                }
                
            } elseif (array_key_exists('gounlimited', $video->foreign_sd)) {
                $requests = Browsershot::url($video->foreign_sd['gounlimited'])
                    ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                    ->triggeredRequests();
                foreach ($requests as $request) {
                    if (strpos($request['url'], '.gounlimited.to/') !== false && strpos($request['url'], 'v.mp4') !== false) {
                        $video->sd = $request['url'];
                        $video->outsource = false;
                        $video->save();
                    }
                }
            }
        }
    }

    /* public function updateData(Request $request)
    {
        $videos = Video::all();
        foreach ($videos as $video) {
            if ($video->data == null || !array_key_exists('views', $video->data)) {
                $views['increment'] = [];
                $views['total'] = [];
                $start = Carbon::parse('2020-08-01 00:00:00');
                $diff = $start->diffInDays(Carbon::now());
                for ($i = 0; $i < $diff; $i++) { 
                    array_push($views['total'], 0);
                    array_push($views['increment'], 0);
                }
            } else {
                $views = $video->data['views'];
            }

            array_push($views['increment'], $video->views - end($views['total']));
            array_push($views['total'], $video->views);
            $video->data = ['views' => $views];
            $video->save();
        }
    } */
}
