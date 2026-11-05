<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.partials.footer', function() {
            View::share([
                'footerData' => json_decode(Storage::get('home-content.json'), true)
            ]);
        });
    }
}
