<?php

declare(strict_types=1);

namespace App\Http\Services\Api\V1;

use App\Http\Resources\Api\V1\ReportResource;
use App\Models\{Driver, Restaurant};
use Illuminate\Support\Collection;

readonly class ReportService
{
	public function __construct(
		private DriverDistanceService $driverDistanceService
	) {}

	public function generateReport(): ReportResource
	{
		$restaurants = Restaurant::with('drivers')->get();
		$drivers = Driver::with('nextRestaurant')->get();

		$drivers = $drivers->map(function ($driver) use ($restaurants) {
			$driver->closestRestaurant = $this->driverDistanceService->closestRestaurant($driver, $restaurants);
			$driver->distanceToAssigned = $this->driverDistanceService->distanceToRestaurant($driver, $driver->nextRestaurant);
			$driver->distanceToClosest = $this->driverDistanceService->distanceToRestaurant($driver, $driver->closestRestaurant);
			return $driver;
		});

		return new ReportResource([
			'restaurants' => $restaurants,
			'drivers' => $drivers,
			'summary' => $this->calculateSummary($restaurants, $drivers),
		]);
	}

	/**
	 * @param Collection<int, Restaurant> $restaurants
	 * @param Collection<int, Driver> $drivers
	 *
	 * @return array<string, mixed>
	 */
	private function calculateSummary(Collection $restaurants, Collection $drivers): array
	{
		$totalDistance = $drivers->sum(fn($driver) => $driver->distanceToAssigned ?? 0);
		$assignedDrivers = $drivers->whereNotNull('next_location')->count();
		$totalOrders = $restaurants->sum('orders_count');
		$totalCapacity = $drivers->sum('capacity');
		$assignedCapacity = $drivers->filter(fn($d) => $d->next_location !== null)->sum('capacity');
		$remainingOrders = max(0, $totalOrders - $assignedCapacity);

		return [
			'total_drivers' => $drivers->count(),
			'assigned_drivers' => $assignedDrivers,
			'total_restaurants' => $restaurants->count(),
			'total_orders' => $totalOrders,
			'total_capacity' => $totalCapacity,
			'assigned_capacity' => $assignedCapacity,
			'remaining_orders' => $remainingOrders,
			'average_distance_km' => $assignedDrivers > 0 ? round($totalDistance / $assignedDrivers, 2) : 0,
			'total_distance_km' => round($totalDistance, 2),
		];
	}
}
