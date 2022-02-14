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
            $httpcode = Motherless::getHttpcode($video->sd);

            if ($httpcode != 200 && $httpcode != 0) {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Motherless check failed ('.$httpcode.')', $video->id, $video->title, $video->sd, 'master', 'master'));
            }
        }

        Log::info('Motherless check ended...');


        Log::info('Motherless sc check started...');

        $videos = Video::where('sd_sc', 'like', '%motherless%')->orderBy('id', 'desc')->get();
        foreach ($videos as $video) {
            $httpcode = Motherless::getHttpcode($video->sd_sc);

            if ($httpcode != 200 && $httpcode != 0) {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Motherless sc check failed ('.$httpcode.')', $video->id, $video->title, $video->sd_sc, 'master', 'master'));
            }
        }

        Log::info('Motherless sc check ended...');


        Log::info('Motherless download check started...');

        $videos = Video::where('foreign_sd', 'like', '%"downloadM"%')->orderBy('id', 'desc')->get();
        foreach ($videos as $video) {
            $httpcode = Motherless::getHttpcode($video->foreign_sd['downloadM']);

            if ($httpcode != 200 && $httpcode != 0) {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Motherless download check failed ('.$httpcode.')', $video->id, $video->title, $video->foreign_sd['downloadM'], 'master', 'master'));
            }
        }

        Log::info('Motherless download check ended...');


        Log::info('Motherless download sc check started...');

        $videos = Video::where('foreign_sd', 'like', '%"downloadM_sc"%')->orderBy('id', 'desc')->get();
        foreach ($videos as $video) {
            $httpcode = Motherless::getHttpcode($video->foreign_sd['downloadM_sc']);

            if ($httpcode != 200 && $httpcode != 0) {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Motherless download sc check failed ('.$httpcode.')', $video->id, $video->title, $video->foreign_sd['downloadM_sc'], 'master', 'master'));
            }
        }

        Log::info('Motherless download sc check ended...');
    }

    public static function getHttpcode(String $url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpcode;
    }
}
