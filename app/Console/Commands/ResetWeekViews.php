<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use App\Comic;

class ResetWeekViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:reset-week-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset week views for videos and comics';

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
        $videos = Video::select('id', 'week_views')->get();
        foreach ($videos as $video) {
            $video->week_views = round($video->week_views / 7);
            $video->save();
        }

        $comics = Comic::select('id', 'week_views')->get();
        foreach ($comics as $comic) {
            $comic->week_views = round($comic->week_views / 7);
            $comic->save();
        }
    }
}
