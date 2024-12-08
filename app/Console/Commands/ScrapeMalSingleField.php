<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Anime;
use App\Helper;
use Illuminate\Support\Facades\Log;

class ScrapeMalSingleField extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daradara:scrape-mal-single-field';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape one field from MAL';

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
        // Scrape is_adult from MAL
        $animes = Anime::where('id', '>', 10230)->where('sources', 'ilike', '%"myanimelist"%')->where('genres', '[]')->where('rating_mal_count', null)->orderBy('id', 'asc')->limit(4)->get();
        foreach ($animes as $anime) {
            $curl_connection = curl_init($anime->sources['myanimelist']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(7);

            if (strpos($html, '404 Not Found') === false) {
                if (strpos($html, '<h1 class="title-name h1_bold_none"><strong>') !== false) {
                    // Scrape genre from MAL
                    if (strpos($html, '<span class="dark_text">Genre') !== false) {
                        $genre_list_raw = trim(Helper::get_string_between($html, '<span class="dark_text">Genre', '<div class="spaceit_pad">'));
                        $genre_list = explode('itemprop="genre"', $genre_list_raw);
                        array_shift($genre_list);
                        $genres = [];
                        foreach ($genre_list as $item) {
                            $genre = trim(Helper::get_string_between($item, 'style="display: none">', '</span>'));
                            array_push($genres, $genre);
                        }
                        $anime->genres = $genres;
                        $anime->save();
                        Log::info("Anime#{$anime->id} genre scraped");
                    } else {
                        Log::info("Anime#{$anime->id} has no genre");
                    }

                    // Scrape ratings count from MAL
                    if (strpos($html, 'data-title="score" data-user="') !== false) {
                        $rating_mal_count = trim(Helper::get_string_between($html, 'data-title="score" data-user="', ' user'));
                        $rating_mal_count = str_replace(',', '', $rating_mal_count);
                        if ($rating_mal_count != '-') {
                            $anime->rating_mal_count = $rating_mal_count;
                            $anime->save();
                            Log::info("Anime#{$anime->id} ratings count scraped");
                        } else {
                            Log::info("Anime#{$anime->id} has no ratings count");
                        }
                        
                    } else {
                        Log::info("Anime#{$anime->id} has no ratings count");
                    }

                } else {
                    Log::warning("Anime#{$anime->id} access failed");
                }
            } else {
                Log::info("Anime#{$anime->id} not found");
            }
        }
    }
}
