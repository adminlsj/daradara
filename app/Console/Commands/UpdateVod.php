<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Video;
use App\Helper;

class UpdateVod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-vod';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hentai with vod as source';

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
        Log::info('Vod update started...');

        $videos = Video::where('foreign_sd', 'like', '%"vod"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {
            $qualities = [];
            $source = $video->foreign_sd['vod'];
            if (strpos($source, '1080p') !== false) {
                $qualities['1080'] = Helper::sign_hembed_url($source, env('HEMBED_TOKEN'), 43200);
                $source = str_replace('-1080p.mp4', '-720p.mp4', $source);
            }
            if (strpos($source, '720p') !== false) {
                $qualities['720'] = Helper::sign_hembed_url($source, env('HEMBED_TOKEN'), 43200);
                $source = str_replace('-720p.mp4', '-480p.mp4', $source);
            }
            if (strpos($source, '480p') !== false) {
                $qualities['480'] = Helper::sign_hembed_url($source, env('HEMBED_TOKEN'), 43200);
                // $source = str_replace('-480p.mp4', '-240p.mp4', $source);
            }
            /* if (strpos($source, '240p') !== false) {
                $qualities['240'] = Helper::sign_hembed_url($source, env('HEMBED_TOKEN'), 43200);
            } */

            $video->sd = reset($qualities);
            $video->qualities = $qualities;
            $video->outsource = false;
            $video->save();

            Log::info('Vod update ID#'.$video->id.' success...');
        }

        Log::info('Vod update ended...');


        Log::info('Vod sc update started...');

        $videos = Video::where('foreign_sd', 'like', '%"vod_sc"%')->select('id', 'title', 'sd_sc', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {
            $qualities_sc = [];
            $source_sc = $video->foreign_sd['vod_sc'];
            if (strpos($source_sc, '1080p') !== false) {
                $qualities_sc['1080'] = Helper::sign_hembed_url($source_sc, env('HEMBED_TOKEN'), 43200);
                $source_sc = str_replace('-1080p.mp4', '-720p.mp4', $source_sc);
            }
            if (strpos($source_sc, '720p') !== false) {
                $qualities_sc['720'] = Helper::sign_hembed_url($source_sc, env('HEMBED_TOKEN'), 43200);
                $source_sc = str_replace('-720p.mp4', '-480p.mp4', $source_sc);
            }
            if (strpos($source_sc, '480p') !== false) {
                $qualities_sc['480'] = Helper::sign_hembed_url($source_sc, env('HEMBED_TOKEN'), 43200);
                // $source_sc = str_replace('-480p.mp4', '-240p.mp4', $source_sc);
            }
            /* if (strpos($source_sc, '240p') !== false) {
                $qualities_sc['240'] = Helper::sign_hembed_url($source_sc, env('HEMBED_TOKEN'), 43200);
            } */

            $video->sd_sc = reset($qualities_sc);
            $video->qualities_sc = $qualities_sc;
            $video->outsource = false;
            $video->save();

            Log::info('Vod sc update ID#'.$video->id.' success...');
        }

        Log::info('Vod sc update ended...');
    }
}
