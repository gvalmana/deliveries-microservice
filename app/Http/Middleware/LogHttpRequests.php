<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogHttpRequests
{
    public function handle($request, Closure $next)
    {
        // Registra la información de la petición en los logs
        Log::channel('daily_custom_requests')->info('Request:', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'headers' => $request->headers->all(),
            'body' => $request->input(),
        ]);

        return $next($request);
    }
}
