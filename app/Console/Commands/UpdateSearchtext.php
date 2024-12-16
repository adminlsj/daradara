<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Anime;

class UpdateSearchtext extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daradara:update-searchtext';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update search text';

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
        $animes = Anime::all();
        foreach ($animes as $anime) {
            $searchtext = $anime->title_zht.'|'.$anime->title_zhs.'|'.$anime->title_jp.'|'.$anime->title_en.'|'.$anime->title_ro.'|'.$anime->season.'|'.$anime->category.'|'.$anime->source.'|'.$anime->animation_studio.'|'.$anime->author.'|'.$anime->director;

            $anime->searchtext = mb_strtolower(preg_replace('/\s+/', '', $searchtext), 'UTF-8');
            $anime->save();
        }
    }
}
