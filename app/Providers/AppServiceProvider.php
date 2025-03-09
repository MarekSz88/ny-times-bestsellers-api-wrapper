<?php

namespace App\Providers;

use App\Services\Interfaces\BestSellers;
use App\Services\NYTimesAPIBestSellersService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BestSellers::class, NYTimesAPIBestSellersService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
