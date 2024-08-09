<?php

namespace App\Providers;

use App\Repositories\CloudflareIntegrationRepository\CloudflareIntegrationRepository;
use App\Repositories\CloudflareIntegrationRepository\Contracts\CloudflareIntegrationRepositoryInterface;
use App\Repositories\MagicLoginTokenRepository\Contracts\MagicLoginTokenRepositoryInterface;
use App\Repositories\MagicLoginTokenRepository\MagicLoginTokenRepository;
use App\Repositories\ServerRepository\Contracts\ServerRepositoryInterface;
use App\Repositories\ServerRepository\ServerRepository;
use App\Repositories\SiteRepository\Contracts\SiteRepositoryInterface;
use App\Repositories\SiteRepository\SiteRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ServerRepositoryInterface::class, ServerRepository::class);
        $this->app->bind(SiteRepositoryInterface::class, SiteRepository::class);
        $this->app->bind(CloudflareIntegrationRepositoryInterface::class, CloudflareIntegrationRepository::class);
        $this->app->bind(MagicLoginTokenRepositoryInterface::class, MagicLoginTokenRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
