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
        $mid = 28447;
        Bot::bilibiliPrePre($mid);
    }

    public function bilibiliPre(Request $request)
    {
        $video_id = 9064;
        $user_id = 363;
        $playlist_id = 252;
        $tags = '鐵公雞二人組 遠藤章造 田中直樹 榊原郁惠 松居直美 SHELLY 濱口優 山崎弘也 小崇小敏 奧黛麗 若林正恭 春日俊彰 挑戰 競賽 明星 搞笑 黃金傳說 いきなり!黄金伝説。 綜藝';
        Bot::bilibiliPre('黃金傳說', $video_id, $user_id, $playlist_id, $tags);
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
        $bots = Bot::all();
        foreach ($bots as $bot) {
            switch (str_ireplace('www.', '', parse_url($bot->data['source'], PHP_URL_HOST))) {
                case 'youtube.com':
                    Bot::youtube($bot);
                    break;

                case 'space.bilibili.com':
                    Bot::bilibili($bot);
                    break;

                case 'yongjiuzy.vip':
                    Bot::yongjiu($bot);
                    break;
            }
        }
    }
}
