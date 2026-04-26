<?php

use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthApiController::class, 'register']);
    Route::post('login', [AuthApiController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthApiController::class, 'logout']);
        Route::get('me', [AuthApiController::class, 'me']);
    });
});
