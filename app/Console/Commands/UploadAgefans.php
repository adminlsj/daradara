<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use App\Bot;

class UploadAgefans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laughseejapan:upload-agefans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload agefans with half auto bot';

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
            if (str_ireplace('www.', '', parse_url($bot->data['source'], PHP_URL_HOST)) == 'agefans.tv') {
                Bot::agefans($bot);
            }
        }
    }
}
