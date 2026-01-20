<?php

declare(strict_types=1);

namespace App\Http\Services\Api\V1;

use App\Helpers\GeoHelper;
use App\Models\{Driver, Restaurant};
use Illuminate\Support\Facades\DB;

class RandomizeService
{
    /** @return array<string, mixed> */
    public function randomize(): array
    {
        DB::beginTransaction();

        try {
            Driver::query()->update([
                'next_location' => null,
            ]);

            $restaurants = Restaurant::all();
            $drivers = Driver::all();

            foreach ($drivers as $driver) {
                $restaurant = $restaurants->random();
                [$lat, $lng] = GeoHelper::randomPointNear(
                    (float) $restaurant->latitude,
                    (float) $restaurant->longitude
                );

                $driver->update([
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'capacity' => rand(1, 4),
                    'next_location' => null,
                ]);
            }

            foreach ($restaurants as $restaurant) {
                $restaurant->update([
                    'orders_count' => rand(5, 50),
                ]);
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Randomization completed successfully',
                'drivers_count' => $drivers->count(),
                'restaurants_count' => $restaurants->count(),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
