<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use App\Bot;

class UploadVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laughseejapan:upload-videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload videos with bot daily';

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
        $bots = Bot::all();
        foreach ($bots as $bot) {
            switch (str_ireplace('www.', '', parse_url($bot->data['source'], PHP_URL_HOST))) {
                case 'youtube.com':
                    Bot::youtube($bot);
                    break;

                case 'space.bilibili.com':
                    Bot::bilibili($bot);
                    break;
            }
        }
        Bot::yongjiu('http://www.yongjiuzy5.com/?m=vod-type-id-14.html');
    }
}
