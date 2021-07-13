<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;

class BotController extends Controller
{
    public function setVideoDuration(Request $request)
    {
        $video = Video::find($request->id);
        $video->duration = round($request->duration);
        $video->save();
    }
}
