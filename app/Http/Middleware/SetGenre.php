<?php

namespace App\Http\Middleware;

use Closure;
use App\Blog;

class SetGenre
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $genre = '';
        if ($request->has('v') && $request->v != 'null') {
            $video = Blog::find($request->v);
            $genre = $video->genre;
            return $next($request);
        } else {
            $genre = 'variety';
            return $next($request);
        }

    }
}
