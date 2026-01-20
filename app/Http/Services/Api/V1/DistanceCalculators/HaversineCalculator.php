<?php

declare(strict_types=1);

namespace App\Http\Services\Api\V1\DistanceCalculators;

class HaversineCalculator implements DistanceCalculatorInterface
{
    private const float EARTH_RADIUS_KM = 6371.0;

    public function distanceKm(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $distanceLat = deg2rad($lat2 - $lat1);
        $distanceLng = deg2rad($lng2 - $lng1);

        $a = sin($distanceLat / 2) * sin($distanceLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($distanceLng / 2) * sin($distanceLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return self::EARTH_RADIUS_KM * $c;
    }
}
