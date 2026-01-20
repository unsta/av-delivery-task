<?php

use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\LogoutController;
use App\Http\Controllers\Api\V1\RandomizeController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\SolveController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:api'])->group(function () {
    Route::prefix('v1')->group(function () {
        Route::post('/login', LoginController::class);

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('/logout', LogoutController::class);

            Route::post('/randomize', RandomizeController::class);
            Route::post('/solve', SolveController::class);
            Route::get('/report', ReportController::class);
        });
    });
});
