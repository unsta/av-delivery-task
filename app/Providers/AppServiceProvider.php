<?php

namespace App\Providers;

use App\Http\Services\Api\V1\DistanceCalculators\DistanceCalculatorInterface;
use App\Http\Services\Api\V1\DistanceCalculators\HaversineCalculator;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
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
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
