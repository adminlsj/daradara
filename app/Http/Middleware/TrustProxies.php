<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
<<<<<<< HEAD
     * @var string
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
=======
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
