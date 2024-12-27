<?php

namespace App\Http\Controllers;

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
        $text = '';
        $category = '';
        $streaming_on = '';
        $country = '';
        $source ='';

        return view('anime.preview.index', ['season' => $season, 'year' => $year], compact('text', 'category', 'streaming_on', 'country', 'source'));
    }

    public function search(Request $request, $season, $year)
    {
        dd($request);
    }
}