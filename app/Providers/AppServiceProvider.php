<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

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

        // Force HTTPS in production or on Railway/Render
        if (config('app.env') === 'production' || 
            isset($_ENV['RAILWAY_ENVIRONMENT']) || 
            isset($_ENV['RENDER']) ||
            str_contains(config('app.url'), 'railway.app') ||
            str_contains(config('app.url'), 'onrender.com')) {
            URL::forceScheme('https');
        }
    }
}
