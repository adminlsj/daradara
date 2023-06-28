<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;

class UpdateSearchtext extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-searchtext';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update searchtext for videos';

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
            $searchtext = $video->title.'|'.$video->translations['JP'].'|'.implode('|', array_keys($video->tags_array)).'|'.$video->genre.'|'.$video->artist;
            if ($video->foreign_sd != null && array_key_exists('characters', $video->foreign_sd)) {
                $searchtext = $searchtext.$video->foreign_sd['characters'];
            }
            $video->searchtext = mb_strtolower(preg_replace('/\s+/', '', $searchtext), 'UTF-8');
            $video->save();
        }
    }
}
