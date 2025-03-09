<?php

namespace App\Providers;

use App\Services\Interfaces\BestSellers;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Tests\Mock\NYTimesAPIBestSellersServiceMock;

class TestingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (app()->environment('testing')) {
            $this->app->bind(BestSellers::class, function (Application $app) {
                return new NYTimesAPIBestSellersServiceMock();
            });
        }
    }

    public function boot(): void
    {
    }
}
