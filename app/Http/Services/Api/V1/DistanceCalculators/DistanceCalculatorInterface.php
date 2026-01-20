<?php

declare(strict_types=1);

namespace App\Http\Services\Api\V1\DistanceCalculators;

interface DistanceCalculatorInterface
{
    public function distanceKm(float $lat1, float $lng1, float $lat2, float $lng2): float;
}
