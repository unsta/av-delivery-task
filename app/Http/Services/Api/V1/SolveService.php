<?php

declare(strict_types=1);

namespace App\Http\Services\Api\V1;

use App\Http\Services\Api\V1\DistanceCalculators\DistanceCalculatorInterface;
use App\Models\{Driver, Restaurant};
use Illuminate\Support\Collection;

readonly class SolveService
{
    private const float WEIGHT_PER_ORDER = 0.1;

    public function __construct(
        private DistanceCalculatorInterface $distanceCalculator
    ) {
    }

    /** @return array<string, mixed> */
    public function solve(): array
    {
        $drivers = Driver::all();
        $restaurants = Restaurant::all();

        $distances = $this->calculateDistances($drivers, $restaurants);
        $assignments = $this->assignDriversToRestaurants($drivers, $restaurants, $distances);

        foreach ($assignments as $driverId => $restaurantId) {
            Driver::where('id', $driverId)->update([
                'next_location' => $restaurantId,
            ]);
        }

        return [
            'success' => true,
            'message' => 'Assignment completed successfully',
            'assignments_count' => count($assignments),
            'total_orders' => $restaurants->sum('orders_count'),
            'total_capacity' => $drivers->sum('capacity')
        ];
    }

    /**
     * @param Collection<int, Driver> $drivers
     * @param Collection<int, Restaurant> $restaurants
     *
     * @return array<int, mixed>
     */
    private function calculateDistances(Collection $drivers, Collection $restaurants): array
    {
        $distances = [];

        foreach ($drivers as $driver) {
            $distances[$driver->id] = [];
            foreach ($restaurants as $restaurant) {
                $distances[$driver->id][$restaurant->id] = $this->distanceCalculator->distanceKm(
                    (float) $driver->latitude,
                    (float) $driver->longitude,
                    (float) $restaurant->latitude,
                    (float) $restaurant->longitude
                );
            }
        }

        return $distances;
    }

    /**
     * @param Collection<int, Driver> $drivers
     * @param Collection<int, Restaurant> $restaurants
     * @param array<int, mixed> $distances
     *
     * @return array<int, mixed>
     */
    private function assignDriversToRestaurants(
        Collection $drivers,
        Collection $restaurants,
        array $distances
    ): array {
        $assignments = [];
        $restaurantOrders = $restaurants->pluck('orders_count', 'id')->toArray();
        $restaurantAssigned = array_fill_keys($restaurants->pluck('id')->toArray(), 0);

        foreach ($drivers->sortByDesc('capacity') as $driver) {
            $bestRestaurant = null;
            $bestScore = INF;

            foreach ($restaurants as $restaurant) {
                $remainingOrders = max(0, $restaurantOrders[$restaurant->id] - $restaurantAssigned[$restaurant->id]);
                $distance = $distances[$driver->id][$restaurant->id];

                $score = $distance - $remainingOrders * self::WEIGHT_PER_ORDER;

                if ($remainingOrders > 0 && $score < $bestScore) {
                    $bestScore = $score;
                    $bestRestaurant = $restaurant;
                }
            }

            if ($bestRestaurant === null) {
                foreach ($restaurants as $restaurant) {
                    $distance = $distances[$driver->id][$restaurant->id];
                    if ($distance < $bestScore) {
                        $bestScore = $distance;
                        $bestRestaurant = $restaurant;
                    }
                }
            }

            if ($bestRestaurant) {
                $assignments[$driver->id] = $bestRestaurant->id;
                $restaurantAssigned[$bestRestaurant->id] += $driver->capacity;
            }
        }

        return $assignments;
    }
}
