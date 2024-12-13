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
        $random = Anime::find(1);
        $count = 5;

        $query = Anime::where('photo_cover', '!=', null)->whereIn('category', ['TV', 'Movie']);

        $最近流行 = $query->where('started_at', '>=', $now->subYear())->where('rating_mal_count', '!=', null)->orderBy('rating_mal_count', 'desc')->limit($count)->get();

        $season = $this->getSeasonByMonth($now->month).' '.$now->year;
        $本季熱門 = $query->where('season', $season)->where('rating_mal_count', '!=', null)->orderBy('rating_mal_count', 'desc')->limit($count)->get();

        $最新上市 = $query->orderby('started_at', 'desc')->limit($count)->get();
        $大家在看 = $query->orderby('updated_at', 'desc')->limit($count)->get();

        $人氣排行 = $query->where('rating_mal_count', '!=', null)->orderBy('rating_mal_count', 'desc')->limit($count)->get();

        $is_mobile = Helper::checkIsMobile();

        $chinese = new Chinese();

        $genre = '全部';
        $tags = [];
        $sort = null;
        $year = null;
        $season = '';
        $category = '';

        return view('layouts.home', compact('random', '最近流行', '本季熱門', '最新上市', '大家在看', '人氣排行', 'is_mobile', 'chinese', 'genre', 'tags', 'sort', 'year', 'season', 'category'));
    }

    private function getSeasonByMonth($month)
    {
        if ($month >= 1 && $month <= 3) {
            return 'Winter';
        } elseif ($month >= 4 && $month <= 6) {
            return 'Spring';
        } elseif ($month >= 7 && $month <= 9) {
            return 'Summer';
        } elseif ($month >= 10 && $month <= 12) {
            return 'Fall';
        }
    }
}
