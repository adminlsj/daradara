<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Video;
use App\Motherless;
use App\Mail\UserReport;
use Illuminate\Support\Facades\Log;

class CheckOdysee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:check-odysee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check videos with odysee source';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        Log::info('Odysee check started...');

        $videos = Video::where('sd', 'like', '%odycdn%')->get();
        foreach ($videos as $video) {
            $url = $video->sd;
            $httpcode = Motherless::getHttpcode($url);

            if ($httpcode == 308) {

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                $html = curl_exec($ch);
                $redirectUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                curl_close($ch);
                $redirectUrl = str_replace('master.m3u8', 'v0.m3u8', $redirectUrl);

                $video->sd = $redirectUrl;
                $video->save();

                // Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Odysee m3u8 updated ('.$httpcode.')', $video->id, $video->title, $video->sd, 'master', 'master'));

            } elseif ($httpcode != 200 && $httpcode != 0) {

                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Odysee check failed ('.$httpcode.')', $video->id, $video->title, $video->sd, 'master', 'master'));

            }
        }

        Log::info('Odysee check ended...');
    }
}
