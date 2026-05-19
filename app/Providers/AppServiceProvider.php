<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Schedule;
use App\Policies\SchedulePolicy;

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
        // Force HTTPS for all generated URLs if the APP_URL is https.
        // This prevents Mixed Content errors on shared hosting.
        if (str_starts_with(config('app.url'), 'https://')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
