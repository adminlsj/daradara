<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use Mail;
use App\Mail\UserReport;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;

class UpdateSpankbang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-spankbang';

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
        Log::info('Spankbang update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"spankbang"%')->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')->get();

        foreach ($videos as $video) {

            $pass = false;
            $sd = '';
            $source = '';
            $default = '';
            $qualities = [];

            $requests = Browsershot::url($video->foreign_sd['spankbang'])
                ->useCookies(['username' => 'admin'])
                ->timeout(3600)
                ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                ->triggeredRequests();

            foreach ($requests as $request) {
                if (strpos($request['url'], 'p.mp4') !== false) {
                    $sd = $request['url'];
                    $source = $request['url'];
                    $pass = true;
                }
            }

            if ($pass) {
                if (in_array('1080p', $video->tags_array)) {
                    $sd = str_replace('-720p.mp4', '-1080p.mp4', $sd);
                    $qualities['1080'] = $sd;
                }
                if (strpos($source, '720p') !== false) {
                    $qualities['720'] = $source;
                    $source = str_replace('-720p.mp4', '-480p.mp4', $source);
                }
                if (strpos($source, '480p') !== false) {
                    $qualities['480'] = $source;
                    $source = str_replace('-480p.mp4', '-240p.mp4', $source);
                }
                if (strpos($source, '240p') !== false) {
                    $qualities['240'] = $source;
                }

                $video->sd = reset($qualities);
                $video->qualities = $qualities;
                $video->outsource = false;
                $video->save();

            } else {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Spankbang update failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                $temp = $video->foreign_sd;
                $temp['error'] = $video->foreign_sd['spankbang'];
                unset($temp['spankbang']);
                $video->foreign_sd = $temp;
                $video->save();
            }
        }

        Log::info('Spankbang update ended...');
    }
}
