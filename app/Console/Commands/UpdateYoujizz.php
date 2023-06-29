<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use App\Helper;
use Mail;
use App\Mail\UserReport;
use Illuminate\Support\Facades\Log;

class UpdateYoujizz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-youjizz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hentai with youjizz as source';

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
        Log::info('Youjizz update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"youjizz"%')
                    ->select('id', 'title', 'sd', 'outsource', 'foreign_sd')
                    ->orderBy('id', 'asc')
                    ->get()
                    ->sortBy(function($video){
                        return (int) Helper::get_string_between($video->sd, 'validfrom=', '&');
                    })
                    ->values();

        foreach ($videos as $video) {
            echo 'ID: '.$video->id.' STARTED<br>';
            Log::info('ID: '.$video->id.' started');
            $url = $video->foreign_sd['youjizz'];
            $url = explode('/', $url);
            $base = array_pop($url);
            $url = implode('/', $url) . '/' . urlencode($base);

            $loop = 0;
            $html = '';
            $start = '';
            $has_hls2e = true;
            while (strpos($html, 'var dataEncodings = ') === false && $loop < 100) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                Log::info("ID#{$video->id} html loop {$loop} failed");
                $loop++;

                sleep(5);
            }
            if (strpos($html, 'var dataEncodings = ') !== false) {
                $start = explode('var dataEncodings = ', $html);
                $end = explode(';' , $start[1]);
                $raw = $end[0];
                if (strpos($raw, 'hls2e-') === false) {
                    $has_hls2e = false;
                }
                $data = json_decode($raw, true);

                $m3u8 = [];
                $mp4 = [];
                foreach ($data as $source) {
                    if (strpos($source['filename'], '.m3u8') === false && is_numeric($source['quality']) && strpos($source['filename'], 'cdn2e') === false) {
                        $mp4[$source['quality']] = 'https:'.$source['filename'];
                    }
                    if (strpos($source['filename'], '.m3u8') !== false && is_numeric($source['quality'])) {
                        $m3u8[$source['quality']] = 'https:'.$source['filename'];
                    }
                }

                if ($has_hls2e) {
                    $video->sd = end($mp4);
                    $video->outsource = true;
                } else {
                    $video->sd = end($m3u8);
                    $video->outsource = false;
                }
                $video->qualities = $mp4;
                $video->save();
                echo 'ID: '.$video->id.' UPDATED<br>';
                Log::info('ID: '.$video->id.' updated');

            } else {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Youjizz update failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                $temp = $video->foreign_sd;
                $temp['error'] = $video->foreign_sd['youjizz'];
                unset($temp['youjizz']);
                $video->foreign_sd = $temp;
                $video->save();
                echo 'ID: '.$video->id.' FAILED<br>';
                Log::info('ID: '.$video->id.' failed');
            }
        }

        Log::info('Youjizz update ended...');
    }
}
