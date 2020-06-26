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
use Mail;
use Auth;
use Image;
use App\Mail\UserReport;
use App\Mail\CopyrightReport;
use App\Mail\UserUploadVideo;
use App\Mail\SubscribeNotify;
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

    public function bilibiliPrePre(Request $request)
    {
        $mid = 272328566;
        Bot::bilibiliPrePre($mid);
    }

    public function bilibiliPre(Request $request)
    {
        $video_id = 11139;
        $user_id = 9489;
        $playlist_id = null;
        Bot::bilibiliPre('blueinta', $video_id, $user_id, $playlist_id);
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
