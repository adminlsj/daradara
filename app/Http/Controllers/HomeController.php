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
        $最近更新 = Anime::orderby('started_at', 'desc')->limit(5)->get();

        $now = Carbon::now();
        $season = $this->getSeasonByMonth($now->month).' '.$now->year;
        $本季流行 = Anime::where('season', $season)->orderby('rating_mal', 'desc')->limit(5)->get();

        $animes = Anime::orderby('id', 'asc')->limit(5)->get();

        return view('layouts.home', compact('animes', '最近更新', '本季流行'));
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
