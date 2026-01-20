<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**  @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        $assignedCapacity = $this->drivers->sum('capacity');
        $remainingOrders = max(0, $this->orders_count - $assignedCapacity);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'latitude' => (float) $this->latitude,
            'longitude' => (float) $this->longitude,
            'orders_count_before' => $this->orders_count,
            'orders_count_after' => $remainingOrders,
            'assigned_capacity' => $assignedCapacity,
            'assigned_drivers_count' => $this->drivers->count(),
        ];
    }
}
