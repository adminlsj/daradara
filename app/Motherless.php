<?php

namespace App;

use Mail;
use App\Video;
use App\Mail\UserReport;
use Illuminate\Support\Facades\Log;

class Motherless
{
    public static function checkMotherless()
    {
        Log::info('Motherless check started...');

        $videos = Video::where('sd', 'like', '%motherless%')->orderBy('id', 'desc')->get();
        foreach ($videos as $video) {
            $ch = curl_init($video->sd);
            curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
            curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_TIMEOUT,10);
            $output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpcode != 200 && $httpcode != 0) {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Motherless check failed ('.$httpcode.')', $video->id, $video->title, $video->sd, 'master', 'master'));
            }
        }

        Log::info('Motherless check ended...');
    }
}
