<?php

namespace App\Http\Controllers;

use App\Preview;
use App\Video;
use App\Comment;
use Illuminate\Http\Request;
use App\Helper;
use Carbon\Carbon;

class PreviewController extends Controller
{
    public function index(Request $request)
    {
        
    }

    public function show(Request $request)
    {
        $uuid = $request->preview;
        $preview = Preview::where('uuid', $uuid)->first();
        $year = substr($uuid, 0, 4);
        $month = ltrim(substr($uuid, 4, 6), '0');

        $prev = Preview::where('id', $preview->id - 1)->first();
        $next = Preview::where('id', $preview->id + 1)->first();

        $videos = Video::whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('created_at', 'asc')->where('uncover', false)->where('tags', 'not like', '泡麵番%')->select('id', 'title', 'translations', 'caption', 'tags_array', 'cover', 'created_at')->get();

        $comments_count = Comment::where('foreign_id', $preview->id)->where('type', 'preview')->count();

        return view('preview.show', compact('preview', 'year', 'month', 'videos', 'comments_count', 'prev', 'next'));
    }
}
