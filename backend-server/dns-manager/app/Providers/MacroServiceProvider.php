<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
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
        $this->registerHTTPMacros();
    }

    private function registerHTTPMacros(): void
    {
        Http::macro(name: 'cloudflare', macro: function (string $token) {
            return Http::baseUrl('https://api.cloudflare.com/client/v4')
                ->withToken($token)
                ->acceptJson();
        });
    }
}
