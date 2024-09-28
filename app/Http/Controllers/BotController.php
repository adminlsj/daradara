<?php

namespace App\Http\Controllers;

use App\User;
use App\Anime;
use App\Character;
use App\Actor;
use App\ActorAnimeCharacter;
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
    public function scrapeMalAnimes(Request $request)
    {
        // from 59091
        $from = $request->from;
        $to = $request->to;
        for ($i = $from; $i <= $to; $i++) {
            if (!Anime::where('sources', 'ilike', '%'.'"https://myanimelist.net/anime/'.$i.'/"'.'%')->exists()) {
                $url = "https://myanimelist.net/anime/{$i}/";
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                sleep(1);

                if (strpos($html, '404 Not Found') === false) {
                    $title_en = trim(Helper::get_string_between($html, '<span class="dark_text">English:</span>', '<'));
                    $title_jp = trim(Helper::get_string_between($html, '<span class="dark_text">Japanese:</span>', '<'));
                    $title_ro = trim(Helper::get_string_between($html, '<strong>', '</strong>'));
                    $photo_cover = trim(Helper::get_string_between($html, '<meta property="og:image" content="', '"'));
                    $description = trim(Helper::get_string_between($html, '<meta property="og:description" content="', '"'));
                    $rating_mal = Helper::get_string_between($html, 'score-label score-', '/span>');
                    $rating_mal = Helper::get_string_between($rating_mal, '>', '<');
                    if ($rating_mal == 'N/A') {
                        $rating_mal = 0.00;
                    }
                    $category = trim(Helper::get_string_between($html, '<span class="dark_text">Type:</span>', '</div>'));
                    $episodes = trim(Helper::get_string_between($html, '<span class="dark_text">Episodes:</span>', '<'));
                    $airing_status = trim(Helper::get_string_between($html, '<span class="dark_text">Status:</span>', '<'));
                    if (strpos($category, "<a href=") !== false) {
                        $category = Helper::get_string_between($category, '>', '<');
                    }
                    if ($episodes == 'Unknown') {
                        $episodes = null;
                    }
                    $aired = trim(Helper::get_string_between($html, '<span class="dark_text">Aired:</span>', '</div>'));
                    $animation_studio = trim(Helper::get_string_between($html, '<span class="dark_text">Studios:</span>', '/a>'));
                    $animation_studio = Helper::get_string_between($animation_studio, '>', '<');
                    $trailer = 'None';
                    if (strpos($html, 'https://www.youtube.com/embed/') !== false) {
                        $trailer = trim(Helper::get_string_between($html, '<a class="iframe js-fancybox-video video-unit promotion" href="', '&autoplay=1"'));
                    }
                    $sources = ["myanimelist" => $url];
                    $array = [];
                    $anime = Anime::create([
                        'title_jp' => $title_jp,
                        'title_en' => $title_en,
                        'title_ro' => $title_ro,
                        'photo_cover' => $photo_cover,
                        'description' => $description,
                        'rating_mal' => $rating_mal,
                        'category' => $category,
                        'airing_status' => $airing_status,
                        'episodes' => $episodes,
                        'animation_studio' => $animation_studio,
                        'trailer' => $trailer,
                        'sources' => $sources,
                        'photo_banner' => $aired,
                        'genres' => $array,
                        'tags' => $array,
                    ]);
                } else {
                    echo "MAL anime#{$i} not found<br>";
                }
            }
        }
    }

    public function tempMethod(Request $request)
    {
        // Scrape voice actors
        $from = $request->from;
        $to = $request->to;
        $actors = Actor::where('id', '>=', $from)->where('id', '<=', $to)->get();
        foreach ($actors as $actor) {
            $curl_connection = curl_init($actor->sources['myanimelist']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, $actor->photo_cover) !== false || $actor->photo_cover == "https://cdn.myanimelist.net/images/questionmark_23.gif") {
                if (strpos($html, 'Given name:') !== false && strpos($html, 'Family name:') !== false) {
                    $actor_given_name = Helper::get_string_between($html, 'span class="dark_text">Given name:</span> ', '</div>');
                    $actor_family_name = Helper::get_string_between($html, 'span class="dark_text">Family name:</span> ', '<div class="spaceit_pad">');
                    $actor->name_jp = "{$actor_family_name}{$actor_given_name}";
                    $actor->save();
                    echo "INFO: Actor#{$actor->id} scraped<br>";

                } else {
                    echo "<span style='color:red'>WARNING: Actor#{$actor->id} has no name</span><br>";
                }
            } else {
                echo "<span style='color:red'>WARNING: Actor#{$actor->id} access failed</span><br>";
            }
        }

        // Scrape character-actor pivot
        /* $from = $request->from;
        $to = $request->to;
        $characters = Character::where('id', '>=', $from)->where('id', '<=', $to)->get();
        foreach ($characters as $character) {
            $curl_connection = curl_init($character->sources['myanimelist']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if ($animes = $character->animes) {
                foreach ($animes as $anime) {
                    $link = $anime->sources['myanimelist'];
                    $role_raw = trim(Helper::get_string_between($html, $link, '/small>'));
                    $role = trim(Helper::get_string_between($role_raw, '<small>', '<'));
                    $pivot_single = ActorAnimeCharacter::where('anime_id', $anime->id)->where('character_id', $character->id)->first();
                    $pivot_single->role = $role;
                    $pivot_single->save();
                }
            }

            if (strpos($html, $character->photo_cover) !== false) {
                if (strpos($html, 'No voice actors have been added to this character.') === false) {
                    $actor_raw = Helper::get_string_between($html, '<div class="normal_header">Voice Actors</div>', '<br>');
                    $actor_raw_array = explode('<table border="0" cellpadding="0" cellspacing="0" width="100%">', $actor_raw);
                    array_shift($actor_raw_array);
                    $actor_details = '';
                    if (strpos($actor_raw, '<small>Japanese</small>') !== false) {
                        foreach ($actor_raw_array as $actor_raw_item) {
                            if (strpos($actor_raw_item, '<small>Japanese</small>') !== false) {
                                $actor_details = $actor_raw_item;
                            }
                        }
                    } else {
                        $actor_details = $actor_raw_array[0];
                    }

                    $actor_link = Helper::get_string_between($actor_details, '<a href="', '"');
                    $actor_sources = ['myanimelist' => $actor_link];
                    $actor_photo = Helper::get_string_between($actor_details, '<img class="lazyload" data-src="', '"');
                    $actor_name_from = '<td class="borderClass" valign="top"><a href="'.$actor_link.'">';
                    $actor_name = trim(Helper::get_string_between($actor_details, $actor_name_from, '</a>'));
                    $actor_language = trim(Helper::get_string_between($actor_details, '<small>', '</small>'));
                    if (!Actor::where('sources', 'ilike', '%"'.$actor_link.'"%')->exists()) {
                        $actor = Actor::create([
                            'name_en' => $actor_name,
                            'photo_cover' => $actor_photo,
                            'language' => $actor_language,
                            'sources' => $actor_sources,
                        ]);
                        echo "INFO: Character#{$character->id} voice actor scraped<br>";
                    } else {
                        $actor = Actor::where('sources', 'ilike', '%"'.$actor_link.'"%')->first();
                        echo "INFO: Character#{$character->id} voice actor exists<br>";
                    }
                    $pivots = ActorAnimeCharacter::where('character_id', $character->id)->get();
                    foreach ($pivots as $pivot) {
                        $pivot->actor_id = $actor->id;
                        $pivot->save();
                    }

                } else {
                    echo "INFO: Character#{$character->id} has no voice actor<br>";
                }
            } else {
                echo "<span style='color:red'>WARNING: Character#{$character->id} access failed</span><br>";
            }
        } */

        // Calculate season based on started at
        /* $animes = Anime::where('started_at', '!=', null)->where('season', null)->get();
        foreach ($animes as $anime) {
            $month = Carbon::parse($anime->started_at)->format('m');
            $year = Carbon::parse($anime->started_at)->format('Y');
            if ($month == '01' || $month == '02' || $month == '03') {
                $anime->season = "Winter {$year}";
            }
            if ($month == '04' || $month == '05' || $month == '06') {
                $anime->season = "Spring {$year}";
            }
            if ($month == '07' || $month == '08' || $month == '09') {
                $anime->season = "Summer {$year}";
            }
            if ($month == '10' || $month == '11' || $month == '12') {
                $anime->season = "Fall {$year}";
            }
            $anime->save();
        } */

        // Extract start date and end date
        /* $animes = Anime::where('photo_banner', 'like', '% \to %')->where('photo_banner', 'not like', '%?%')->orderBy('id', 'desc')->get();
        foreach ($animes as $anime) {
            try {
                $started_at = explode(' to ', $anime->photo_banner)[0];
                $anime->started_at = Carbon::createFromFormat('!M d, Y', $started_at, '0');   
                $anime->save();  
            } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                echo "ID#{$anime->id} invalid start date<br>";
            }
            try {
                $ended_at = explode(' to ', $anime->photo_banner)[1];
                $anime->ended_at = Carbon::createFromFormat('!M d, Y', $ended_at, '0'); 
                $anime->save();  
            } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                echo "ID#{$anime->id} invalid end date<br>";
            }
        }

        $animes = Anime::where('photo_banner', 'like', '%, %')->orderBy('id', 'desc')->get();
        foreach ($animes as $anime) {
            $anime->started_at = Carbon::createFromFormat('!M d, Y', $anime->photo_banner, '0'); 
            $anime->photo_banner = null;  
            $anime->save();
        } */

        // Scrape anime character pivot
        /* $from = $request->from;
        $to = $request->to;
        $characters = Character::where('id', '>=', $from)->where('id', '<=', $to)->get();
        foreach ($characters as $character) {
            $curl_connection = curl_init($character->sources['myanimelist']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            $animeography = Helper::get_string_between($html, '<div class="normal_header character-anime">Animeography</div>', '</table>');
            $anime_links = explode('<div class="picSurround">', $animeography);
            array_shift($anime_links);
            foreach ($anime_links as $link) {
                $mal_id = Helper::get_string_between($link, '<a href="https://myanimelist.net/anime/', '/');
                if ($anime = Anime::where('sources', 'ilike', '%'.'"https://myanimelist.net/anime/'.$mal_id.'/"'.'%')->first()) {
                    if (!AnimeCharacter::where('anime_id', $anime->id)->where('character_id', $character->id)->exists()) {
                        $animeCharacter = AnimeCharacter::create([
                            'anime_id' => $anime->id,
                            'character_id' => $character->id,
                        ]);
                        echo "Anime#{$anime->id} and Character#{$character->id} link success<br>";
                    } else {
                        echo "Anime#{$anime->id} and Character#{$character->id} link exists<br>";
                    }
                } else {
                    return "MAL ID#{$mal_id} not scraped";
                }
            }
            echo "Character#{$character->id} complete<br>";
        } */

        // Scrape MAL characters
        /* $from = $request->from;
        $to = $request->to;
        $characters = Character::where('id', '>=', $from)->where('id', '<=', $to)->get();
        foreach ($characters as $character) {
            if (!AnimeCharacter::where('character_id', $character->id)->exists()) {
                $curl_connection = curl_init($character->sources['myanimelist']);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                sleep(1);

                if (strpos($html, $character->photo_cover) !== false) {
                    $animeography = Helper::get_string_between($html, '<div class="normal_header character-anime">Animeography</div>', '</table>');
                    $anime_links = explode('<div class="picSurround">', $animeography);
                    array_shift($anime_links);
                    foreach ($anime_links as $link) {
                        $mal_id = Helper::get_string_between($link, '<a href="https://myanimelist.net/anime/', '/');
                        if ($anime = Anime::where('sources', 'ilike', '%'.'"https://myanimelist.net/anime/'.$mal_id.'/"'.'%')->first()) {
                            if (!AnimeCharacter::where('anime_id', $anime->id)->where('character_id', $character->id)->exists()) {
                                $animeCharacter = AnimeCharacter::create([
                                    'anime_id' => $anime->id,
                                    'character_id' => $character->id,
                                ]);
                                echo "Anime#{$anime->id} and Character#{$character->id} link success<br>";
                            } else {
                                echo "Anime#{$anime->id} and Character#{$character->id} link exists<br>";
                            }
                        } else {
                            return "MAL ID#{$mal_id} not scraped";
                        }
                    }
                    echo "Character#{$character->id} complete<br>";
                } else {
                    echo "Character#{$character->id} access failed<br>";
                }
            }
        } */

        // Scrape characters
        /* for ($i = $request->start; $i <= $request->end; $i++) { 

            $url = "https://myanimelist.net/character/{$i}";

            if (!Character::where('sources', 'ilike', "%{$url}%")->exists()) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'Invalid ID provided') !== false) {
                    echo $i.' page not found<br>';

                } else {
                    $name_en = trim(Helper::get_string_between($html, '<h2 class="normal_header" style="height: 15px;">', '<'));
                    $name_jp = trim(Helper::get_string_between($html, '<small>(', ')</small>'));
                    $description = trim(Helper::get_string_between($html, '</h2>', '<div'));
                    $description = iconv(mb_detect_encoding($description, mb_detect_order(), true), "UTF-8//IGNORE", $description);
                    $photo_cover = trim(Helper::get_string_between($html, '<meta property="og:image" content="', '"'));
                    $sources = [];
                    $sources["myanimelist"] = $url;
                    if ($photo_cover == '' && $name_en == '' && $name_jp == '' && $description == '') {
                        echo $i.' page access failed<br>';
                    } else {
                        $character = Character::create([
                            'photo_cover' => $photo_cover,
                            'name_en' => $name_en,
                            'name_jp' => $name_jp,
                            'description' => $description,
                            'sources' => $sources,
                        ]);
                    }
                }

            } else {
                echo $i.' character exists<br>';
            }
        } */

        /* if ($request->column == 'startenddate') {
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

        } elseif ($request->column == 'genre') {
            $animes = Anime::where('genres', '[]')->orderBy('id', 'desc')->get();
            foreach ($animes as $anime) {
                $url = 'https://myanimelist.net/anime/16498/';
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, '<span class="dark_text">Genres:</span>') !== false) {
                    $genres = trim(Helper::get_string_between($html, '<span class="dark_text">Genres:</span>', '</div>'));
                    $genres = explode(',', $genres);
                    foreach ($genres as &$genre) {
                        $genre = trim(Helper::get_string_between($genre, '<span itemprop="genre" style="display: none">', '</span>'));
                    }
                }
                $anime->save();

                if ($animes->last() != $anime) {
                    sleep(10);
                }
            }
        } */
    }
}