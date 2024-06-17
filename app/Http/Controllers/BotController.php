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
        for ($i = 60000; $i < 70000; $i++) { 
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
        }
    }
}