<?php

namespace App\Http\Controllers;

use App\Anime;
use Illuminate\Http\Request;
use Response;
use Auth;
use Mail;
use Redirect;
use Storage;
use Session;
use App\Helper;
use Carbon\Carbon;
use SteelyWing\Chinese\Chinese;
use Illuminate\Database\Eloquent\Builder;

class PreviewController extends Controller{
    public function index(Request $request, $season, $year)
    {
        $TV = Anime::where('season', trim(ucfirst($season).' '.$year))->where('photo_cover', '!=', null)->where('category', 'TV')->where('rating_mal_count', '!=', null)->orderBy('rating_mal_count', 'desc')->get();
        $Movie = Anime::where('season', trim(ucfirst($season).' '.$year))->where('photo_cover', '!=', null)->where('category', 'Movie')->where('rating_mal_count', '!=', null)->orderBy('rating_mal_count', 'desc')->get();
        $OVA = Anime::where('season', trim(ucfirst($season).' '.$year))->where('photo_cover', '!=', null)->whereIn('category', ['OVA', 'ONA', 'Special'])->where('rating_mal_count', '!=', null)->orderBy('rating_mal_count', 'desc')->get();

        $text = '';
        $category = '';
        $streaming_on = '';
        $country = '';
        $source ='';
        $chinese = new Chinese();

        return view('anime.preview.index', ['season' => $season, 'year' => $year], compact('TV', 'Movie', 'OVA', 'text', 'category', 'streaming_on', 'country', 'source', 'chinese'));
    }

    public function search(Request $request, $season, $year)
    {
        dd($request);
    }

    public function menu(Request $request)
    {
        $animes = Anime::where('rating_mal_count', '!=', null)->where('photo_cover', '!=', null)->where('season','!=',null)->whereIn('category', ['TV', 'Movie', 'OVA', 'ONA', 'Special'])->orderBy('rating_mal_count', 'desc')->get();
        
        return view('anime.preview.menu', compact('animes'));
    }

    public function airing(Request $request)
    {
        $animes = Anime::where('airing_status', '=', 'Currently Airing')->where('photo_cover', '!=', null)->whereIn('category', ['TV', 'Movie', 'OVA', 'ONA', 'Special'])->where('rating_mal_count', '!=', null)->get();

        $carbon = new Carbon();

        $text = '';
        $category = '';
        $streaming_on = '';
        $country = '';
        $source ='';
        $chinese = new Chinese();

        return view('anime.preview.airing', compact('animes', 'text', 'category', 'streaming_on', 'country', 'source', 'chinese', 'carbon'));
    }
}