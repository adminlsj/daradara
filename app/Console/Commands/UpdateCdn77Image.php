<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;

class UpdateCdn77Image extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-cdn77Image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update images with Cdn77 as source';

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
        $videos = Video::where('cover', 'like', '%vdownload.hembed.com%')->get();
        foreach ($videos as $video) {
            $filename = explode('.jpg', substr($video->cover, strrpos($video->cover, '/') + 1))[0].'.jpg';
            $url = 'vdownload.hembed.com';
            $expiration = time() + 43200;
            $token = 'xVEO8rLVgGkUBEBg';
            $source = '/image/cover/'.$filename;
            $video->cover = Video::getSignedUrlParameter($url, $source, $token, $expiration);
            $video->save();
        }
    }
}
