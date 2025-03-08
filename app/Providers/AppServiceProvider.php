<?php

namespace App\Providers;

use App\Services\BestSellersService;
use App\Services\Interfaces\BestSellers;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BestSellers::class, BestSellersService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
