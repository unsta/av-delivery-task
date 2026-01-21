<?php

declare(strict_types=1);

namespace Feature\Controllers\Api\V1;

use Database\Seeders\DriversSeeder;
use Database\Seeders\RestaurantsSeeder;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithoutMiddleware};
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    private const string ENDPOINT = 'api/v1/report';

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            RestaurantsSeeder::class,
            DriversSeeder::class,
        ]);
    }

    public function test_invoke(): void
    {
        $response = $this->getJson(self::ENDPOINT);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'restaurants' => [
                        '*' => [
                            'id',
                            'title',
                            'latitude',
                            'longitude',
                            'orders_count_before',
                            'orders_count_after',
                            'assigned_capacity',
                            'assigned_drivers_count',
                        ],
                    ],
                    'drivers' => [
                        '*' => [
                            'id',
                            'name',
                            'latitude',
                            'longitude',
                            'capacity',
                            'assigned_restaurant_id',
                            'assigned_restaurant_title',
                            'distance_to_assigned_km',
                            'closest_restaurant_id',
                            'closest_restaurant_title',
                            'distance_to_closest_km',
                        ],
                    ],
                    'summary' => [
                        'total_drivers',
                        'assigned_drivers',
                        'total_restaurants',
                        'total_orders',
                        'total_capacity',
                        'assigned_capacity',
                        'remaining_orders',
                        'average_distance_km',
                        'total_distance_km',
                    ],
                ],
            ]);
    }
}
