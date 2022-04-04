<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;

class ResetMonthViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:reset-month-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset month views for videos and comics';

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
        $videos = Video::select('id', 'month_views')->get();
        foreach ($videos as $video) {
            $video->month_views = round($video->month_views / 30);
            $video->save();
        }
    }
}
