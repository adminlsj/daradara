<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Video;
use App\Helper;

class UpdateHembed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-hembed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hentai with hembed as source';

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
        Log::info('Hembed update started...');

        $videos = Video::where('foreign_sd', 'like', '%"hembed"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {
            $qualities = [];
            $source = $video->foreign_sd['hembed'];
            if (strpos($source, '1080p') !== false) {
                $qualities['1080'] = Helper::sign_bcdn_url($source, env('BUNNY_TOKEN'), 43200);
                $source = str_replace('-1080p.mp4', '-720p.mp4', $source);
            }
            if (strpos($source, '720p') !== false) {
                $qualities['720'] = Helper::sign_bcdn_url($source, env('BUNNY_TOKEN'), 43200);
                $source = str_replace('-720p.mp4', '-480p.mp4', $source);
            }
            if (strpos($source, '480p') !== false) {
                $qualities['480'] = Helper::sign_bcdn_url($source, env('BUNNY_TOKEN'), 43200);
                $source = str_replace('-480p.mp4', '-240p.mp4', $source);
            }
            if (strpos($source, '240p') !== false) {
                $qualities['240'] = Helper::sign_bcdn_url($source, env('BUNNY_TOKEN'), 43200);
            }

            $video->sd = reset($qualities);
            $video->qualities = $qualities;
            $video->outsource = false;
            $video->save();

            Log::info('Hembed update ID#'.$video->id.' success...');
        }

        Log::info('Hembed update ended...');
    }
}
