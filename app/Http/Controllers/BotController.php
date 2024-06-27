<?php

namespace App\Http\Controllers;

use App\User;
use App\Anime;
use Illuminate\Http\Request;
use Response;
use Auth;
use Mail;
use App\Mail\UserReport;
use Redirect;
use Storage;
use App\Helper;
use SteelyWing\Chinese\Chinese;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class BotController extends Controller
{
    public function tempMethod(Request $request)
    {
        if ($request->column == 'description') {
            $animes = Anime::where('description', null)->orWhere('description', '')->orderBy('id', 'desc')->get();
            foreach ($animes as $anime) {
                $url = $anime->sources['myanimelist'];
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                $description = Helper::get_string_between($html, '<meta property="og:description" content="', '"');
                $anime->description = $description;

                $anime->save();
            }

        } elseif ($request->column == 'rating_mal') {
            $animes = Anime::where('rating_mal', null)->orWhere('rating_mal', 0.00)->orderBy('id', 'desc')->get();
            foreach ($animes as $anime) {
                $url = $anime->sources['myanimelist'];
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                $rating_mal = Helper::get_string_between($html, 'score-label score-', '/span>');
                $rating_mal = Helper::get_string_between($rating_mal, '>', '<');
                if ($rating_mal == 'N/A') {
                    $anime->rating_mal = 0.00;
                } else {
                    $anime->rating_mal = $rating_mal;
                }

                $anime->save();
            }

        } elseif ($request->column == 'titles') {
            $animes = Anime::where('title_jp', null)->orWhere(function($query) {
                $query->where('title_jp', '')->where('title_en', '');
            })->orderBy('id', 'desc')->get();
            foreach ($animes as $anime) {
                $url = $anime->sources['myanimelist'];
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                $title_en = trim(Helper::get_string_between($html, '<span class="dark_text">English:</span>', '<'));
                $title_jp = trim(Helper::get_string_between($html, '<span class="dark_text">Japanese:</span>', '<'));

                $anime->title_en = $title_en;
                $anime->title_jp = $title_jp;

                $anime->save();
            }

        } elseif ($request->column == 'startenddate') {
            $animes = Anime::where('airing_status', 'like', '% \to %')->where('airing_status', 'not like', '%?%')->orderBy('id', 'desc')->get();
            foreach ($animes as $anime) {
                try {
                    $started_at = explode(' to ', $anime->airing_status)[0];
                    $anime->started_at = Carbon::createFromFormat('!M d, Y', $started_at, '0');   
                    $anime->save();  
                } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                    echo "ID#{$anime->id} invalid start date<br>";
                }
                try {
                    $ended_at = explode(' to ', $anime->airing_status)[1];
                    $anime->ended_at = Carbon::createFromFormat('!M d, Y', $ended_at, '0'); 
                    $anime->save();  
                } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                    echo "ID#{$anime->id} invalid end date<br>";
                }
            }

        } elseif ($request->column == 'season') {
            $animes = Anime::where('started_at', '!=', null)->get();
            foreach ($animes as $anime) {
                $season = '';
                $started_at_month = Carbon::parse($anime->started_at)->month;
                if ($started_at_month >= 1 && $started_at_month <= 3) {
                    $season = 'Winter';
                } elseif ($started_at_month >= 4 && $started_at_month <= 6) {
                    $season = 'Spring';
                } elseif ($started_at_month >= 7 && $started_at_month <= 9) {
                    $season = 'Summer';
                } elseif ($started_at_month >= 10 && $started_at_month <= 12) {
                    $season = 'Fall';
                }

                $anime->season = $season.' '.Carbon::parse($anime->started_at)->year;
                $anime->save();
            }
        }

        /* for ($i = 60000; $i < 70000; $i++) { 
            $url = "https://myanimelist.net/anime/{$i}/";
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            if (strpos($html, '404 Not Found') === false) {
                $title = Helper::get_string_between($html, '<strong>', '</strong>');
                $sources = [];
                $sources["myanimelist"] = $url;
                $anime = Anime::create([
                    'title_ro' => $title,
                    'sources' => $sources,
                ]);

            } else {
                echo $i.' not found<br>';
            }
        } */
    }
}