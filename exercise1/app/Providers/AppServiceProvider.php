<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Http::globalOptions([
            'connect_timeout' => config('app.http.connect_timeout'),
            'timeout' => config('app.http.timeout'),
        ]);
    }
}
