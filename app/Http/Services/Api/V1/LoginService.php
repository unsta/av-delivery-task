<?php

declare(strict_types=1);

namespace App\Http\Services\Api\V1;

use App\Http\Exceptions\Api\V1\LoginException;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Hash;

readonly class LoginService
{
    public function createToken(string $email, string $password): string
    {
        $user = User::where('email', $email)->first();

        if (null === $user || false === Hash::check($password, $user->password)) {
            throw new LoginException();
        }

        $user->tokens()->delete();

        return $user->createToken('token-name', ['*'], CarbonImmutable::now()->addHour())->plainTextToken;
    }
}
