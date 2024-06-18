<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Anime;
use App\Helper;

class ImportFromMAL extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:import-from-mal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import datas from MAL';

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
        $anime = Anime::where('photo_cover', null)->first();
        $url = $anime->sources['myanimelist'];
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($curl_connection);
        curl_close($curl_connection);

        $photo_cover = Helper::get_string_between($html, '<img class="lazyload" data-src="', '"');
        $anime->photo_cover = $photo_cover;
        $anime->save();
    }
}
