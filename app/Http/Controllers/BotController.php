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

class BotController extends Controller
{
    public function tempMethod(Request $request)
    {

        if ($request->column == 'description') {
            $animes = Anime::where('description', null)->orderBy('id', 'desc')->get();
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
            $animes = Anime::where('rating_mal', null)->orderBy('id', 'desc')->get();
            foreach ($animes as $anime) {
                $url = $anime->sources['myanimelist'];
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                $rating_mal = Helper::get_string_between($html, 'score-label score-', '/');
                $rating_mal = Helper::get_string_between($rating_mal, '>', '<');
                $anime->rating_mal = $rating_mal;

                $anime->save();
            }

        } elseif ($request->column == 'titles') {
            $animes = Anime::where('title_jp', null)->orderBy('id', 'desc')->get();
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