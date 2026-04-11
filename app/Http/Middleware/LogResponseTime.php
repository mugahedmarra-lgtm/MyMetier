<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogResponseTime
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);

        $response = $next($request);

        $time = (microtime(true) - $start) * 1000;
        $memory = memory_get_peak_usage(true);

        logger('REQUEST TIME', [
            'url' => $request->url(),
            'time_ms' => round($time, 2),
            'memory_mb' => round($memory / 1024 / 1024, 2),
        ]);

        if ($time > 500) {
            logger()->warning('SLOW REQUEST ALERT', [
                'url' => $request->url(),
                'time_ms' => round($time, 2),
                'memory_mb' => round($memory / 1024 / 1024, 2),
            ]);
        }

        return $response;
    }
}
