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
        $year = substr($uuid, 0, 4);
        $month = ltrim(substr($uuid, 4, 6), '0');

        $current = Carbon::createFromFormat('Ym d H:i:s',  $uuid.' 15 00:00:00');
        $prev = Preview::where('uuid', $current->subMonths(1)->format('Ym'))->first();
        $next = Preview::where('uuid', $current->addMonths(2)->format('Ym'))->first();

        $previews = Preview::with('video:id,title,imgur,translations,caption,tags_array,cover,artist,created_at')->where('uuid', $uuid)->orderBy('created_at', 'asc')->get();

        $comments_count = Comment::where('foreign_id', $uuid)->where('type', 'preview')->count();

        $is_mobile = Helper::checkIsMobile();

        return view('preview.show', compact('previews', 'year', 'month', 'comments_count', 'prev', 'next', 'is_mobile'));
    }
}
