<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRequestInfo
{
    public function handle($request, Closure $next)
    {
        $ip = $request->ip();
        $method = $request->method();
        $uri = $request->getRequestUri();

        Log::info("Request from IP: $ip - $method $uri");

        return $next($request);
    }
}