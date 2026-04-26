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
         * This prevents "Mixed Content" blocks and 401 errors during uploads.
         */
        if (app()->environment('production') || env('FORCE_HTTPS', true)) {
            URL::forceScheme('https');
        }

        /**
         * Standardizes pagination for a responsive mobile/laptop experience.
         */
        Paginator::useTailwind();
    }
}