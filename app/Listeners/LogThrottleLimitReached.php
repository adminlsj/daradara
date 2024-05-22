<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogThrottleLimitReached
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $request = $event->request;

        \Log::error(sprintf(
            'Throttling rate limit reached. IP: %s, URL: %s, Body: %s',
            $request->ip(),
            $request->url(),
            json_encode($request->all())
        ));
    }
}
