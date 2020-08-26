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
        $videos = Video::where('tags', 'ilike', '%裏番%')->where('foreign_sd', '!=', null)->get();
        foreach ($videos as $video) {
            if (array_key_exists('spankbang', $video->foreign_sd)) {
                $requests = Browsershot::url($video->foreign_sd['spankbang'])
                    ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                    ->triggeredRequests();
                foreach ($requests as $request) {
                    if (strpos($request['url'], 'spankbang.com/stream/') !== false && strpos($request['url'], '.mp4') !== false) {
                        $curl_connection = curl_init();
                        curl_setopt($curl_connection, CURLOPT_URL, $request['url']);
                        curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, true); // follow the redirects
                        curl_setopt($curl_connection, CURLOPT_NOBODY, true); // get the resource without a body
                        curl_exec($curl_connection);
                        $redirect = curl_getinfo($curl_connection, CURLINFO_EFFECTIVE_URL);
                        curl_close($curl_connection);
                        $video->sd = str_replace('720p', '1080p', $redirect);
                        $video->outsource = false;
                        $video->save();
                    }
                }
            }
        }
    }
}
