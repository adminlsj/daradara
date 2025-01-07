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

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        $count = 6;

        $最近流行 = Anime::where('photo_cover', '!=', null)->whereIn('category', ['TV', 'Movie'])->where('started_at', '>=', $now->subYear())->where('rating_mal_count', '!=', null)->orderBy('rating_mal_count', 'desc')->limit($count)->get();

        $season = Helper::getSeasonByMonth($now->month).' '.$now->year;
        $本季熱門 = Anime::where('photo_cover', '!=', null)->whereIn('category', ['TV', 'Movie'])->where('season', $season)->where('rating_mal_count', '!=', null)->orderBy('rating_mal_count', 'desc')->limit($count)->get();

        $最新上市 = Anime::where('photo_cover', '!=', null)->whereIn('category', ['TV', 'Movie'])->orderby('started_at', 'desc')->limit($count)->get();
        $大家在看 = Anime::where('photo_cover', '!=', null)->whereIn('category', ['TV', 'Movie'])->orderby('updated_at', 'desc')->limit($count)->get();

        $人氣排行 = Anime::where('photo_cover', '!=', null)->whereIn('category', ['TV', 'Movie'])->where('rating_mal_count', '!=', null)->orderBy('rating_mal_count', 'desc')->limit($count)->get();

        $is_mobile = Helper::checkIsMobile();

        $chinese = new Chinese();

        $genre = '全部';
        $tags = [];
        $sort = null;
        $year = null;
        $season = '';
        $category = '';
        $airing_status = '';
        $streaming_on = '';
        $country = '';
        $source = '';
        $text = '';

        return view('layouts.home', compact('最近流行', '本季熱門', '最新上市', '大家在看', '人氣排行', 'is_mobile', 'chinese', 'genre', 'tags', 'sort', 'year', 'season', 'category', 'airing_status', 'streaming_on', 'country', 'source', 'text'));
    }
}
