<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HSTSMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        if ($request->isSecure() || app()->environment('local')) {
            return $response;
        }
        $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubdomains');

        return $response;
    }
}
