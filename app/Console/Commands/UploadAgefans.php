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
        $curl_connection = curl_init('https://www.agefans.tv/update');
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $content = curl_exec($curl_connection);
        curl_close($curl_connection);
        $link = 'https://www.agefans.tv'.Bot::get_string_between(explode('</h4>', explode('<h4 class="anime_icon2_name">', $content)[1])[0], '<a href="', '">');

        $bots = Bot::where('temp', $link)->get();
        foreach ($bots as $bot) {
            Bot::agefans($bot);
        }
    }
}
