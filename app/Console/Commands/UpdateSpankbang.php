<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use Spatie\Browsershot\Browsershot;

class UpdateSpankbang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laughseejapan:update-spankbang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hentai with spankbang as source';

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
        $videos = Video::where('tags', 'ilike', '%裏番%')->where('foreign_sd', 'ilike', '%"spankbang"%')->get();
        foreach ($videos as $video) {
            $requests = Browsershot::url($video->foreign_sd['spankbang'])
                ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                ->triggeredRequests();
            foreach ($requests as $request) {
                if (strpos($request['url'], 'https://vdownload') !== false && strpos($request['url'], '.mp4') !== false) {
                    if (strpos($video->tags, ' 1080p ') !== false) {
                        $video->sd = str_replace('720p', '1080p', $request['url']);
                    } else {
                        $video->sd = $request['url'];
                    }
                    
                    $video->outsource = false;
                    $video->save();
                }
            }
        }
    }
}
