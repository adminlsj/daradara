<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use App\Comic;

class ResetViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:reset-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset views for videos and comics';

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
        // Day views
        Video::where('id', '!=', null)->update(['current_views' => 0]);
        Comic::where('id', '!=', null)->update(['day_views' => 0]);

        // Week views
        $videos = Video::select('id', 'week_views')->get();
        foreach ($videos as $video) {
            $video->week_views = round($video->week_views * 6 / 7);
            $video->save();
        }

        $comics = Comic::select('id', 'week_views')->get();
        foreach ($comics as $comic) {
            $comic->week_views = round($comic->week_views * 6 / 7);
            $comic->save();
        }

        // Month views
        $videos = Video::select('id', 'month_views')->get();
        foreach ($videos as $video) {
            $video->month_views = round($video->month_views * 29 / 30);
            $video->save();
        }
    }
}
