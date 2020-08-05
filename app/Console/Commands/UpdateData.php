<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use Carbon\Carbon;

class UpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laughseejapan:update-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update video views total and increment';

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
        $videos = Video::all();
        foreach ($videos as $video) {
            if ($video->data == null || !array_key_exists('views', $video->data)) {
                $views['increment'] = [];
                $views['total'] = [];
                $start = Carbon::parse('2020-08-01 00:00:00');
                $diff = $start->diffInDays(Carbon::now());
                for ($i = 0; $i < $diff; $i++) { 
                    array_push($views['total'], 0);
                    array_push($views['increment'], 0);
                }
            } else {
                $views = $video->data['views'];
            }

            array_push($views['increment'], $video->views - end($views['total']));
            array_push($views['total'], $video->views);
            $video->data = ['views' => $views];
            $video->save();
        }
    }
}
