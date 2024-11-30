<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Anime;
use App\Helper;

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
        $animes = Anime::where('is_adult', null)->orderBy('id', 'asc')->get();
        foreach ($animes as $anime) {
            $curl_connection = curl_init($anime->sources['myanimelist']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, '404 Not Found') === false) {
                if (strpos($html, '<h1 class="title-name h1_bold_none"><strong>') !== false) {
                    // Scrape is_adult
                    if (strpos($html, '<span class="dark_text">Rating:</span>') !== false) {
                        $adult_rating = trim(Helper::get_string_between($html, '<span class="dark_text">Rating:</span>', '</div>'));
                        if ($adult_rating == 'Rx - Hentai' || $adult_rating == 'R+ - Mild Nudity') {
                            $anime->is_adult = true;
                        } else {
                            $anime->is_adult = false;
                        }
                        $anime->save();

                    } else {
                        Log::info("Anime#{$anime->id} has no adult ratings");
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
