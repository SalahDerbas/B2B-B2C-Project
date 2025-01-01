<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\Source\SourcePackageInterface;
use App\Services\Source\AiraloSourceService;

class SourceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SourcePackageInterface::class , AiraloSourceService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
