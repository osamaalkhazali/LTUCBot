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
        // Force HTTPS on production environments (Railway, Render, etc.)
        if (!$request->secure() && 
            (config('app.env') === 'production' || 
             isset($_ENV['RAILWAY_ENVIRONMENT']) || 
             isset($_ENV['RENDER']) ||
             str_contains($request->getHost(), 'railway.app') ||
             str_contains($request->getHost(), 'onrender.com'))) {
            
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
