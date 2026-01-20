<?php

namespace App\Providers;

use App\Http\Services\Api\V1\DistanceCalculators\DistanceCalculatorInterface;
use App\Http\Services\Api\V1\DistanceCalculators\HaversineCalculator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
		$this->app->bind(DistanceCalculatorInterface::class, HaversineCalculator::class);
	}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
