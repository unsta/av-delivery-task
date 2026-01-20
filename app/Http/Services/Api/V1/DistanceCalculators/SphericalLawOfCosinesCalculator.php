<?php

declare(strict_types=1);

namespace App\Http\Services\Api\V1\DistanceCalculators;

class SphericalLawOfCosinesCalculator implements DistanceCalculatorInterface
{
    private const float EARTH_RADIUS_KM = 6371.0;

    public function distanceKm(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $lat1Rad = deg2rad($lat1);
        $lat2Rad = deg2rad($lat2);
        $distanceLng = deg2rad($lng2 - $lng1);

        return acos(
            sin($lat1Rad) * sin($lat2Rad) +
            cos($lat1Rad) * cos($lat2Rad) * cos($distanceLng)
        ) * self::EARTH_RADIUS_KM;
    }
}
