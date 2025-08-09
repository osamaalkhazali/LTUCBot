<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Configure trusted proxies and force HTTPS for production
        if (config('app.env') === 'production' || 
            isset($_ENV['RAILWAY_ENVIRONMENT']) || 
            isset($_ENV['RENDER'])) {
            
            // Trust all proxies for Railway/Render
            $this->app['request']->setTrustedProxies(['*'], Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO);
            
            // Force HTTPS scheme
            URL::forceScheme('https');
        }
    }
}
