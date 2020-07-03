<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;

class UpdateVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laughseejapan:update-videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all videos in terms of links from quan and qzone';

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
        $quan = Video::where('sd', 'like', '%1098\_%')->get();
        $qzone = Video::where('sd', 'like', '%1006\_%')->orWhere('sd', 'like', '%1097\_%')->get();
        
        foreach ($quan as $video) {
            $sd = $this->get_string_between($video->sd, 'vmtt.tc.qq.com/', '.f0.mp4');
            $video->sd = 'https://www.agefans.tv/age/player/ckx1/?url='.urlencode(Video::getSourceQQ("https://quan.qq.com/video/".$sd));
            $video->save();
        }

        foreach ($qzone as $video) {
            $sd = $this->get_string_between($video->sd, 'vwecam.tc.qq.com/', '.f0.mp4');
            $video->sd = 'https://www.agefans.tv/age/player/ckx1/?url='.urlencode(Video::getSourceQZ($sd));
            $video->save();
        }
    }

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
