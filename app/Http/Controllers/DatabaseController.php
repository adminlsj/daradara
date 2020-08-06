<?php

namespace App\Http\Controllers;

use App\Video;
use App\Bot;
use App\Watch;
use App\Subscribe;
use App\User;
use App\Avatar;
use App\Comment;
use App\Like;
use App\Save;
use App\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Response;
use Mail;
use Auth;
use Image;
use App\Mail\UserReport;
use App\Mail\CopyrightReport;
use App\Mail\UserUploadVideo;
use App\Mail\SubscribeNotify;
use SteelyWing\Chinese\Chinese;
use Redirect;
use simplehtmldom\HtmlWeb;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Schema;

class DatabaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        return view('layouts.database');
    }

    public function show(String $table, Request $request)
    {
        if ($table == 'saves') {
            $model = 'App\Save';
        } else {
            $model = 'App\\'.studly_case(strtolower(str_singular($table)));
        }

        $results = (new $model)::query();

        if ($request->exists('column') && $request->exists('expression') && $request->exists('dbquery')) {
            switch ($request->expression) {
                case 'contains':
                    $results = $results->where($request->column, 'ilike', '%'.$request->dbquery.'%');
                    break;

                case 'is exactly':
                    $results = $results->where($request->column, '=', $request->dbquery);
                    break;
            }
        }

        if ($request->exists('sort') && $request->exists('order')) {
            $results = $results->orderBy($request->sort, $request->order);
        } else {
            $results = $results->orderBy('id', 'desc');
        }

        $results = $results->paginate(20);

        $columns = Schema::getColumnListing($table);

        return view('layouts.table', compact('table', 'results', 'columns'));
    }

    public function edit(String $table, Request $request)
    {
        $columns = Schema::getColumnListing($table);
        $row = [];
        $model = 'App\\'.studly_case(strtolower(str_singular($table)));
        $row = (new $model)::find($request->id);
        return view('database.edit', compact('table', 'columns', 'row'));
    }

    public function update(String $table, Request $request)
    {
        $model = 'App\\'.studly_case(strtolower(str_singular($table)));
        $row = (new $model)::find($request->id);
        $columns = Schema::getColumnListing($table);

        foreach ($columns as $column) {
            if ($column == 'foreign_sd' || $column == 'data') {
                $row->{$column} = json_decode($request->{$column}, 1);
            } elseif ($column == 'outsource') {
                $row->{$column} = $request->{$column} ? true : false;
            } else {
                $row->{$column} = $request->{$column};
            }
        }
        $row->save();

        return redirect()->action('DatabaseController@edit', ['table' => $table, 'id' => $request->id]);
    }

    public function analytics(Request $request)
    {
        $anime = Video::where('data', '!=', null)->where('tags', 'ilike', '% 動漫 %')->select('id', 'title', 'data', 'views')->get();
        $variety = Video::where('data', '!=', null)->where('tags', 'ilike', '%綜藝%')->select('id', 'title', 'data', 'views')->get();
        $drama = Video::where('data', '!=', null)->where('tags', 'ilike', '%日劇%')->select('id', 'title', 'data', 'views')->get();
        $hentai = Video::where('data', '!=', null)->where('tags', 'ilike', '%裏番%')->select('id', 'title', 'data', 'views')->get();

        $count = count($anime->first()->data['views']['increment']);
        $atotal = $vtotal = $dtotal = $htotal = [];

        for ($i = 0; $i < $count; $i++) { 
            array_push($atotal, 0);
            array_push($vtotal, 0);
            array_push($dtotal, 0);
            array_push($htotal, 0);
        }

        $videos = ['anime' => $anime, 'variety' => $variety, 'drama' => $drama, 'hentai' => $hentai];
        $totals = ['anime' => $atotal, 'variety' => $vtotal, 'drama' => $dtotal, 'hentai' => $htotal];
        foreach ($videos as $key => $value) {
            foreach ($value as $video) {
                $increment = $video->data['views']['increment'];
                $i = 0;
                foreach ($increment as $views) {
                    $totals[$key][$i] = $totals[$key][$i] + $views;
                    $i++;
                }
            }
        }

        return view('database.analytics', compact('videos', 'totals', 'count')); 
    }

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
