<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;
use App\Spankbang;

class UpdateEmptySd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-emptysd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hscangku empty sd';

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
        Log::info('Empty sd update started...');

        $base = "http://513hsck.cc";
        $videos = Video::where('foreign_sd', 'like', '%"hscangku"%')
                    ->where('sd', '')
                    ->orderBy('id', 'asc')
                    ->get()
                    ->values()
                    ->slice(0, 3);;

        foreach ($videos as $video) {
            $hscangku_html = Browsershot::url("{$base}{$video->foreign_sd['hscangku']}")
                ->timeout(20)
                ->ignoreHttpsErrors()
                ->disableImages()
                ->disableJavascript()
                ->setExtraHttpHeaders(['Cookie' => '958b5d3d17412f7fbb21304527cba94f=a9258058d2afa28c4f737d782eb5cbd5; Hm_lvt_9c69de51657cb6e2da4f620629691e94=1689056890; Hm_lpvt_9c69de51657cb6e2da4f620629691e94=1689056890; cb3f8eeef124d1b64215702a6c508b31=0a737054063e1d2de784ef706312b3b4'])
                ->setExtraHttpHeaders(['Referer' => $base])
                ->setOption('args', ['--disable-web-security'])
                ->userAgent(Spankbang::$userAgents[array_rand(Spankbang::$userAgents)])
                ->bodyHtml();

            $sd = 'https:'.str_replace('\\', '', Helper::get_string_between($hscangku_html, '"url":"https:', '"'));
            if ($sd != '' && $sd != null && $sd != 'https:') {
                $video->sd = 'https:'.str_replace('\\', '', Helper::get_string_between($hscangku_html, '"url":"https:', '"'));
                $video->save();
                Log::info('Empty sd update ID#'.$video->id.' success...');

            } else {
                Log::info('Empty sd update ID#'.$video->id.' failed...');
            }

            if ($videos->last() != $video) {
                sleep(10);
            }
        }

        Log::info('Empty sd update ended...');
    }
}
