<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttpsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Don't redirect if we're already on HTTPS or behind a proxy that provides HTTPS
        if (
            $request->secure() ||
            $request->header('X-Forwarded-Proto') === 'https' ||
            $request->header('X-Forwarded-Ssl') === 'on') {
            return $next($request);
        }

        // Only redirect to HTTPS on production environments
        if (
            config('app.env') === 'production' ||
            isset($_ENV['RAILWAY_ENVIRONMENT']) ||
            isset($_ENV['RENDER']) ||
            str_contains($request->getHost(), 'railway.app') ||
            str_contains($request->getHost(), 'onrender.com')) {

            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
