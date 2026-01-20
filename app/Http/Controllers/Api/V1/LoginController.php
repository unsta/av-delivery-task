<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Services\Api\V1\LoginService;
use Illuminate\Http\JsonResponse;

readonly class LoginController
{
    public function __construct(public LoginService $service)
    {
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'token' => $this->service->createToken($request->email, $request->password),
        ]);
    }
}
