<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
	/** @return array<string, mixed> */
	public function toArray(Request $request): array
	{
		return [
			'restaurants' => RestaurantResource::collection($this['restaurants']),
			'drivers' => DriverResource::collection($this['drivers']),
			'summary' => $this['summary'],
		];
	}
}
