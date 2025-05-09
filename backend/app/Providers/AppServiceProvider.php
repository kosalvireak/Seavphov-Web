<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

         app('router')->matched(function ($event) {
            $request = $event->request;

            $ip = $request->ip();
            $method = $request->method();
            $uri = $request->path();

            Log::info("Access from IP: $ip - $method $uri");
        });

    }
}