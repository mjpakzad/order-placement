<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\API\V1\OrderController;

Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::resource('orders', OrderController::class)->only('store');
});
