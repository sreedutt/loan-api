<?php

namespace App\App\Api\Routes;

use App\Api\Controllers\CustomerController;
use App\Api\Controllers\LoanController;
use App\Api\Controllers\RepaymentController;

use Illuminate\Support\Facades\Route;

Route::post('/customers', [CustomerController::class, 'store']);
Route::post('/customers/login', [CustomerController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/loans', [LoanController::class, 'get']);
    Route::get('/loans/{uuid}', [LoanController::class, 'find']);
    Route::post('/loans', [LoanController::class, 'store']);
    Route::post('/scheduled-repayments/{uuid}/repayments', [RepaymentController::class, 'store']);
});
