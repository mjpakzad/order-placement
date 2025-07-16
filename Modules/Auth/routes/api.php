<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\API\V1\AuthController;

Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
    Route::post('logout',   [AuthController::class, 'logout']);
    Route::post('refresh',  [AuthController::class, 'refresh']);
    Route::get('me',       [AuthController::class, 'me']);
});
