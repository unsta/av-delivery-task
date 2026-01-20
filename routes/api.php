<?php

use App\Http\Controllers\Api\V1\RandomizeController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\SolveController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/randomize', RandomizeController::class);
    Route::post('/solve', SolveController::class);
    Route::get('/report', ReportController::class);
});
