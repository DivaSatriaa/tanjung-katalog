<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        /*
         * Di hosting yang memakai HTTPS lewat proxy, permintaan bisa sampai
         * ke aplikasi sebagai HTTP. Paksa skema HTTPS bila APP_URL memakainya
         * agar URL aset dan tautan tidak diblokir sebagai mixed content.
         */
        if (Str::startsWith((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
