<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

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
        $country_code = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : 'N/A';
        $ip_address = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : 'N/A';
        $user_agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : 'N/A';

        if ($country_code == 'N/A' || $ip_address == 'N/A' || $user_agent == 'N/A') {
            Log::info('Outbound Access - Country Code: '.$country_code.' | IP Address: '.$ip_address.' | User Agent: '.$user_agent);
        }

        return $next($request);
    }
}
