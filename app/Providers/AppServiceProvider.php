<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;

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
        /**
         * Force HTTPS on Render production environment.
         * This is CRITICAL for Cloudinary images to show up correctly.
         * It prevents browsers from blocking images as "Mixed Content".
         */
        if (config('app.env') === 'production' || env('FORCE_HTTPS', true)) {
            URL::forceScheme('https');
        }

        /**
         * Standardizes pagination for a responsive mobile/laptop experience.
         */
        Paginator::useTailwind();
    }
}