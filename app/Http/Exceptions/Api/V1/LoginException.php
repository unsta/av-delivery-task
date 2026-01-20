<?php

declare(strict_types=1);

namespace App\Http\Exceptions\Api\V1;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid email or password');
    }

    public function render(): JsonResponse
    {
        return new JsonResponse([
            'message' => $this->getMessage()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
