<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Video;
use App\Helper;

class UpdateCdn77 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-cdn77';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update cdn77 videos';

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
        $url = 'vdownload.hembed.com';
        $expiration = time() + 43200;
        $token = 'xVEO8rLVgGkUBEBg';

        Log::info('Cdn77 update started...');

        $videos = Video::where('foreign_sd', 'like', '%"cdn77"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {
            $qualities = [];
            $source = str_replace('https://'.$url, '', $video->foreign_sd['cdn77']);
            if (strpos($source, '1080p') !== false) {
                $qualities['1080'] = Video::getSignedUrlParameter($url, $source, $token, $expiration);
                $source = str_replace('-1080p.mp4', '-720p.mp4', $source);
            }
            if (strpos($source, '720p') !== false) {
                $qualities['720'] = Video::getSignedUrlParameter($url, $source, $token, $expiration);
                $source = str_replace('-720p.mp4', '-480p.mp4', $source);
            }
            if (strpos($source, '480p') !== false) {
                $qualities['480'] = Video::getSignedUrlParameter($url, $source, $token, $expiration);
            }

            $video->sd = reset($qualities);
            $video->qualities = $qualities;
            $video->outsource = false;
            $video->save();

            Log::info('Cdn77 update ID#'.$video->id.' success...');
        }

        Log::info('Cdn77 update ended...');


        Log::info('Cdn77 sc update started...');

        $videos = Video::where('foreign_sd', 'like', '%"cdn77_sc"%')->select('id', 'title', 'sd_sc', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {
            $qualities_sc = [];
            $source_sc = str_replace('https://'.$url, '', $video->foreign_sd['cdn77_sc']);
            if (strpos($source_sc, '1080p') !== false) {
                $qualities_sc['1080'] = Video::getSignedUrlParameter($url, $source_sc, $token, $expiration);
                $source_sc = str_replace('-1080p.mp4', '-720p.mp4', $source_sc);
            }
            if (strpos($source_sc, '720p') !== false) {
                $qualities_sc['720'] = Video::getSignedUrlParameter($url, $source_sc, $token, $expiration);
                $source_sc = str_replace('-720p.mp4', '-480p.mp4', $source_sc);
            }
            if (strpos($source_sc, '480p') !== false) {
                $qualities_sc['480'] = Video::getSignedUrlParameter($url, $source_sc, $token, $expiration);
            }

            $video->sd_sc = reset($qualities_sc);
            $video->qualities_sc = $qualities_sc;
            $video->outsource = false;
            $video->save();

            Log::info('Cdn77 sc update ID#'.$video->id.' success...');
        }

        Log::info('Cdn77 sc update ended...');
    }
}
