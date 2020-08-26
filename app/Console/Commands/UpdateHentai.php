<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use Spatie\Browsershot\Browsershot;

class UpdateHentai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laughseejapan:update-hentai';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all hentai at once';

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
        $videos = Video::where('tags', 'ilike', '%裏番%')->where('foreign_sd', '!=', null)->get();
        foreach ($videos as $video) {
            if (array_key_exists('spankbang', $video->foreign_sd)) {
                $requests = Browsershot::url($video->foreign_sd['spankbang'])
                    ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                    ->triggeredRequests();
                foreach ($requests as $request) {
                    if (strpos($request['url'], 'spankbang.com/stream/') !== false && strpos($request['url'], '.mp4') !== false) {
                        $second_requests = Browsershot::url($request['url'])
                            ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                            ->triggeredRequests();
                        foreach ($second_requests as $second_request) {
                            if (strpos($second_request['url'], 'vdownload') !== false && strpos($second_request['url'], '.mp4') !== false) {
                                $video->sd = str_replace('720p', '1080p', $second_request['url']);
                                $video->outsource = false;
                                $video->save();
                            }
                        }
                    }
                }
                
            } elseif (array_key_exists('youjizz', $video->foreign_sd)) {
                $requests = Browsershot::url($video->foreign_sd['youjizz'])
                    ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                    ->triggeredRequests();
                foreach ($requests as $request) {
                    if (strpos($request['url'], 'https://cdne-mobile.youjizz.com/') !== false && strpos($request['url'], '.mp4') !== false) {
                        $video->sd = $request['url'];
                        $video->outsource = false;
                        $video->save();
                    }
                }
                
            } elseif (array_key_exists('slutload', $video->foreign_sd)) {
                $requests = Browsershot::url($video->foreign_sd['slutload'])
                    ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                    ->triggeredRequests();
                foreach ($requests as $request) {
                    if (strpos($request['url'], 'https://v-rn.slutload-media.com/') !== false) {
                        $video->sd = $request['url'];
                        $video->outsource = false;
                        $video->save();
                    }
                }
                
            }
        }
    }
}
