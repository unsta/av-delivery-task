<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\RandomizeService;
use Illuminate\Http\JsonResponse;

class RandomizeController extends Controller
{
    public function __construct(
        private readonly RandomizeService $randomizeService
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $result = $this->randomizeService->randomize();
        return response()->json($result);
    }
}
