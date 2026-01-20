<?php

declare(strict_types=1);

namespace App\Http\Services\Api\V1;

use App\Http\Services\Api\V1\DistanceCalculators\DistanceCalculatorInterface;
use App\Models\{Driver, Restaurant};
use Illuminate\Support\Collection;

readonly class DriverDistanceService
{
	public function __construct(private DistanceCalculatorInterface $distanceCalculator) {}

	public function closestRestaurant(Driver $driver, Collection $restaurants): ?Restaurant
	{
		$closest = null;
		$minDistance = INF;

		foreach ($restaurants as $restaurant) {
			$distance = $this->distanceCalculator->distanceKm(
				(float) $driver->latitude,
				(float) $driver->longitude,
				(float) $restaurant->latitude,
				(float) $restaurant->longitude
			);

			if ($distance < $minDistance) {
				$minDistance = $distance;
				$closest = $restaurant;
			}
		}

		return $closest;
	}

	public function distanceToRestaurant(Driver $driver, ?Restaurant $restaurant): ?float
	{
		if (!$restaurant) {
			return null;
		}

		return $this->distanceCalculator->distanceKm(
			(float) $driver->latitude,
			(float) $driver->longitude,
			(float) $restaurant->latitude,
			(float) $restaurant->longitude
		);
	}
}
