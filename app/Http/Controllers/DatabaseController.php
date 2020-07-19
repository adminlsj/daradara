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

        if ($request->exists('sort') && $request->exists('order')) {
            $results = (new $model)::orderBy($request->sort, $request->order)->paginate(20);
        } else {
            $results = (new $model)::orderBy('id', 'desc')->paginate(20);
        }

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

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
