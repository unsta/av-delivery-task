<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$restaurants = [
			['title' => 'Хепи Бъкстон', 'lat' => 42.667122, 'lng' => 23.281657],
			['title' => 'Хепи Виктория', 'lat' => 42.688600, 'lng' => 23.308027],
			['title' => 'Хепи Саут Парк', 'lat' => 42.670071, 'lng' => 23.313399],
			['title' => 'Хепи Будапеща', 'lat' => 42.692017, 'lng' => 23.326259],
			['title' => 'Хепи Мол София', 'lat' => 42.6982608, 'lng' => 23.3078595],
			['title' => 'Хепи Младост', 'lat' => 42.6481687, 'lng' => 23.3793724],
			['title' => 'Хепи Света Неделя', 'lat' => 42.696606, 'lng' => 23.3204766],
			['title' => 'Хепи Люлин', 'lat' => 42.713895, 'lng' => 23.264476],
			['title' => 'Хепи Парадайс', 'lat' => 42.6570524, 'lng' => 23.3142243],
			['title' => 'Happy Изток', 'lat' => 42.673136, 'lng' => 23.348732],
		];

		foreach ($restaurants as $restaurant) {
			Restaurant::create([
				'title' => $restaurant['title'],
				'latitude' => $restaurant['lat'],
				'longitude' => $restaurant['lng'],
				'orders_count' => rand(5, 50),
			]);
		}
	}
}
