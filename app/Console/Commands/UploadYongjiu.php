<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use App\Bot;

class UploadYongjiu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laughseejapan:upload-yongjiu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload yongjiu with auto bot';

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
        Bot::yongjiu('http://www.yongjiuzy5.com/?m=vod-type-id-14.html');
    }
}
