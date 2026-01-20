<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\SolveService;
use Illuminate\Http\JsonResponse;

class SolveController extends Controller
{
    public function __construct(
        private readonly SolveService $solveService
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $result = $this->solveService->solve();
        return response()->json($result);
    }
}
