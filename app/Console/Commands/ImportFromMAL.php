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
    protected $signature = 'daradara:import-from-mal';

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
        $animes = Anime::where('photo_cover', null)->orderBy('id', 'desc')->limit(3)->get();
        foreach ($animes as $anime) {
            $url = $anime->sources['myanimelist'];
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $photo_cover = Helper::get_string_between($html, '<img class="lazyload" data-src="', '"');
            $anime->photo_cover = $photo_cover;

            $description = Helper::get_string_between($html, '<meta property="og:description" content="', '"');
            $anime->description = $description;

            $rating_mal = Helper::get_string_between($html, 'score-label score-', '/');
            $rating_mal = Helper::get_string_between($rating_mal, '>', '<');
            if (is_numeric($rating_mal)) {
                $anime->rating_mal = $rating_mal;
            } else {
                $anime->rating_mal = 0.00;
            }

            $title_en = trim(Helper::get_string_between($html, '<span class="dark_text">English:</span>', '<'));
            $title_jp = trim(Helper::get_string_between($html, '<span class="dark_text">Japanese:</span>', '<'));
            $anime->title_en = $title_en;
            $anime->title_jp = $title_jp;

            $anime->save();

            if ($animes->last() != $anime) {
                sleep(10);
            }
        }
    }
}
