<?php

declare(strict_types=1);

namespace App\Helpers;

class GeoHelper
{
	private const int KM_PER_DEGREE = 111;
	private const int RANDOM_PRECISION = 1000;

	/** @return array<int, mixed> */
	public static function randomPointNear(float $lat, float $lng, float $maxKm = 5): array
	{
		$maxOffset = $maxKm / self::KM_PER_DEGREE;

		$latOffset = rand(-self::RANDOM_PRECISION, self::RANDOM_PRECISION) / self::RANDOM_PRECISION * $maxOffset;
		$lngOffset = rand(-self::RANDOM_PRECISION, self::RANDOM_PRECISION) / self::RANDOM_PRECISION * $maxOffset;

		return [
			$lat + $latOffset,
			$lng + $lngOffset
		];
	}
}
