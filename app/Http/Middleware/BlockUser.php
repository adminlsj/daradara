<?php

namespace App\Http\Middleware;

use Closure;

class BlockUser
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
        if (!isset($_SERVER["HTTP_CF_IPCOUNTRY"]) || !isset($_SERVER["HTTP_CF_CONNECTING_IP"]) || !isset($_SERVER["HTTP_USER_AGENT"])) {
            abort(403);
        }
        // Log::info('USER INFO - COUNTRY CODE: '.$country_code.' / IP ADDRESS: '.$ip_address.' / USER AGENT: '.$user_agent);

        return $next($request);
    }
}
