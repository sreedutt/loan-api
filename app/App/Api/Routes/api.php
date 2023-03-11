<?php

namespace App\App\Api\Routes;

use App\Api\Controllers\CustomerController;
use App\Api\Controllers\LoanController;

use Illuminate\Support\Facades\Route;

Route::post('/customers', [CustomerController::class, 'store']);
Route::post('/customers/login', [CustomerController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/loans', [LoanController::class, 'get']);
    Route::post('/loans', [LoanController::class, 'store']);
});
