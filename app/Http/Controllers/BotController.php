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
        $animes = Anime::where('trailer', 'ilike', '%&autoplay=1%')->get();
        foreach ($animes as $anime) {
            $anime->trailer = str_replace('&autoplay=1', '', $anime->trailer);
            $anime->save();
        }

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

        } elseif ($request->column == 'categoryEpisodesAiringstatus') {
            $animes = Anime::where('category', null)->orWhere('category', '')->orderBy('id', 'desc')->get();
            foreach ($animes as $anime) {
                $url = $anime->sources['myanimelist'];
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                $category = trim(Helper::get_string_between($html, '<span class="dark_text">Type:</span>', '</div>'));
                $episodes = trim(Helper::get_string_between($html, '<span class="dark_text">Episodes:</span>', '<'));
                $airing_status = trim(Helper::get_string_between($html, '<span class="dark_text">Status:</span>', '<'));

                if (strpos($category, "<a href=") !== false) {
                    $anime->category = Helper::get_string_between($category, '>', '<');
                } else {
                    $anime->category = $category;
                }
                if ($episodes != 'Unknown') {
                    $anime->episodes = $episodes;
                }
                $anime->airing_status = $airing_status;

                $anime->save();
            }

        } elseif ($request->column == 'animation_studio') {
            $animes = Anime::where('animation_studio', null)->orWhere('animation_studio', '')->orderBy('id', 'desc')->get();
            foreach ($animes as $anime) {
                $url = $anime->sources['myanimelist'];
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                $animation_studio = trim(Helper::get_string_between($html, '<span class="dark_text">Studios:</span>', '/a>'));
                $animation_studio = Helper::get_string_between($animation_studio, '>', '<');

                $anime->animation_studio = $animation_studio;

                $anime->save();
            }

        } elseif ($request->column == 'trailer') {
            $animes = Anime::where('trailer', null)->orWhere('trailer', '')->orWhere('trailer', 'None')->orderBy('id', 'desc')->get();
            foreach ($animes as $anime) {
                $url = $anime->sources['myanimelist'];
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'https://www.youtube.com/embed/') !== false) {
                    $anime->trailer = trim(Helper::get_string_between($html, '<a class="iframe js-fancybox-video video-unit promotion" href="', '"'));
                } else {
                    $anime->trailer = 'None';
                }

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