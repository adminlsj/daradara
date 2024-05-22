<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAdminUser
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
        if (!Auth::check() || Auth::user()->email != 'laughseejapan@gmail.com') {
            abort(403);
        }
        return $next($request);
    }
}
