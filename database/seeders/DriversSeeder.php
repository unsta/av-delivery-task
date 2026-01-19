<?php

namespace Database\Seeders;

use App\Helpers\GeoHelper;
use App\Models\Driver;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriversSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$restaurants = Restaurant::all();

		for ($i = 1; $i <= 100; $i++) {
			$restaurant = $restaurants->random();

			[$lat, $lng] = GeoHelper::randomPointNear($restaurant->latitude, $restaurant->longitude);

			Driver::create([
				'name' => 'Driver ' . $i,
				'latitude' => $lat,
				'longitude' => $lng,
				'capacity' => rand(1, 4),
				'next_location' => null,
			]);
		}
	}
}
