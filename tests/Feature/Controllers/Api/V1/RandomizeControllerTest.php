<?php

declare(strict_types=1);

namespace Feature\Controllers\Api\V1;

use Database\Seeders\DriversSeeder;
use Database\Seeders\RestaurantsSeeder;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithoutMiddleware};
use Tests\TestCase;

class RandomizeControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    private const string ENDPOINT = 'api/v1/randomize';

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
        $response = $this->postJson(self::ENDPOINT);

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Randomization completed successfully',
                'drivers_count' => 100,
                'restaurants_count' => 10,
            ]);
    }
}
