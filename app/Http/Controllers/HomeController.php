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

        $query = Anime::where('photo_cover', '!=', null)->whereIn('category', ['TV', 'Movie']);

        $最近流行 = $query->where('started_at', '>=', $now->subYear())->orderBy('rating_mal_count', 'desc')->limit(24)->get();

        $season = $this->getSeasonByMonth($now->month).' '.$now->year;
        $本季熱門 = $query->where('season', $season)->inRandomOrder()->limit(24)->get();

        $最新上市 = $query->orderby('started_at', 'desc')->limit(24)->get();
        $最新上傳 = $query->orderby('created_at', 'desc')->limit(24)->get();
        $大家在看 = $query->orderby('updated_at', 'desc')->limit(24)->get();

        $is_mobile = Helper::checkIsMobile();

        $chinese = new Chinese();

        $genre = '全部';
        $tags = [];
        $sort = null;
        $year = null;
        $season = '';
        $category = '';

        return view('layouts.home-new', compact('random', '最近流行', '本季熱門', '最新上市', '最新上傳', '大家在看', 'is_mobile', 'chinese', 'genre', 'tags', 'sort', 'year', 'season', 'category'));
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
