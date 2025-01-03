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

class PreviewController extends Controller
{
    public function show(Request $request, $season, $year)
    {
        $TV = Anime::where('season', trim(ucfirst($season) . ' ' . $year))->where('photo_cover', '!=', null)->where('category', 'TV')->where('rating_mal_count', '!=', null)->orderBy('rating_mal_count', 'desc')->get();
        $Movie = Anime::where('season', trim(ucfirst($season) . ' ' . $year))->where('photo_cover', '!=', null)->where('category', 'Movie')->where('rating_mal_count', '!=', null)->orderBy('rating_mal_count', 'desc')->get();
        $OVA = Anime::where('season', trim(ucfirst($season) . ' ' . $year))->where('photo_cover', '!=', null)->whereIn('category', ['OVA', 'ONA', 'Special'])->where('rating_mal_count', '!=', null)->orderBy('rating_mal_count', 'desc')->get();

        $text = '';
        $category = '';
        $source = '';
        $chinese = new Chinese();
        
        $sorting = '人氣';

        return view('anime.preview.show', ['season' => $season, 'year' => $year], compact('TV', 'Movie', 'OVA', 'text', 'category', 'source', 'chinese', 'sorting'));
    }

    public function search(Request $request, $season, $year)
    {
        $TV = Anime::where('season', trim(ucfirst($season) . ' ' . $year))->where('photo_cover', '!=', null)->where('category', 'TV')->where('rating_mal_count', '!=', null);
        $Movie = Anime::where('season', trim(ucfirst($season) . ' ' . $year))->where('photo_cover', '!=', null)->where('category', 'Movie')->where('rating_mal_count', '!=', null);
        $OVA = Anime::where('season', trim(ucfirst($season) . ' ' . $year))->where('photo_cover', '!=', null)->whereIn('category', ['OVA', 'ONA', 'Special'])->where('rating_mal_count', '!=', null);

        $text = '';
        $category = '';
        $source = '';
        $chinese = new Chinese();

        if ($sorting = $request->sorting) {
            switch ($sorting) {
                case '標題':
                    $TV = $TV->orderBy('title_zht', 'asc')->get();
                    $Movie = $Movie->orderBy('title_zht', 'asc')->get();
                    $OVA = $OVA->orderBy('title_zht', 'asc')->get();
                    break;

                case '人氣':
                    $TV = $TV->orderBy('rating_mal_count', 'desc')->get();
                    $Movie = $Movie->orderBy('rating_mal_count', 'desc')->get();
                    $OVA = $OVA->orderBy('rating_mal_count', 'desc')->get();
                    break;

                case '評分':
                    $TV = $TV->orderBy('rating_mal_count', 'desc')->get();
                    $Movie = $Movie->orderBy('rating_mal_count', 'desc')->get();
                    $OVA = $OVA->orderBy('rating_mal_count', 'desc')->get();
                    break;

                case '首播日期':
                    $TV = $TV->orderBy('started_at', 'asc')->get();
                    $Movie = $Movie->orderBy('started_at', 'asc')->get();
                    $OVA = $OVA->orderBy('started_at', 'asc')->get();
                    break;

                case '完播日期':
                    $TV = $TV->orderBy('ended_at', 'asc')->get();
                    $Movie = $Movie->orderBy('ended_at', 'asc')->get();
                    $OVA = $OVA->orderBy('ended_at', 'asc')->get();
                    break;

                case '製作公司':
                    $TV = $TV->orderBy('animation_studio', 'asc')->get();
                    $Movie = $Movie->orderBy('animation_studio', 'asc')->get();
                    $OVA = $OVA->orderBy('animation_studio', 'asc')->get();
                    break;

                default:
                    break;
            }
        }

        return view('anime.preview.show', ['season' => $season, 'year' => $year], compact('TV', 'Movie', 'OVA', 'text', 'category', 'source', 'chinese', 'sorting'));
    }

    public function index(Request $request)
    {
        $animes = Anime::where('rating_mal_count', '!=', null)->where('photo_cover', '!=', null)->where('season', '!=', null)->whereIn('category', ['TV', 'Movie', 'OVA', 'ONA', 'Special'])->orderBy('rating_mal_count', 'desc')->get();

        return view('anime.preview.index', compact('animes'));
    }

    public function airing(Request $request)
    {
        $animes = Anime::where('airing_status', '=', 'Currently Airing')->where('photo_cover', '!=', null)->whereIn('category', ['TV'])->where('rating_mal_count', '!=', null)->get();

        $carbon = new Carbon();

        $text = '';
        $category = '';
        $streaming_on = '';
        $country = '';
        $source = '';
        $chinese = new Chinese();

        return view('anime.preview.airing', compact('animes', 'text', 'category', 'streaming_on', 'country', 'source', 'chinese', 'carbon'));
    }
}