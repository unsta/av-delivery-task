<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'latitude' => (float) $this->latitude,
			'longitude' => (float) $this->longitude,
			'capacity' => $this->capacity,
			'assigned_restaurant_id' => $this->next_location,
			'assigned_restaurant_title' => $this->nextRestaurant?->title,
			'distance_to_assigned_km' => $this->distanceToAssigned !== null ? round($this->distanceToAssigned, 2) : null,
			'closest_restaurant_id' => $this->closestRestaurant?->id,
			'closest_restaurant_title' => $this->closestRestaurant?->title,
			'distance_to_closest_km' => $this->distanceToClosest !== null ? round($this->distanceToClosest, 2) : null,
		];
    }
}
