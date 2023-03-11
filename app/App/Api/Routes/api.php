<?php

namespace App\App\Api\Routes;

use Illuminate\Support\Facades\Route;
use App\Api\Controllers\LoanController;
use App\Api\Controllers\CustomerController;
use App\Api\Controllers\RepaymentController;
use App\Api\Controllers\ScheduleRepaymentController;

Route::post('/customers', [CustomerController::class, 'store']);
Route::post('/customers/login', [CustomerController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/loans', [LoanController::class, 'get']);
    Route::get('/loans/{uuid}', [LoanController::class, 'find']);
    Route::get('/loans/{uuid}/scheduled-repayments', [ScheduleRepaymentController::class, 'get']);
    Route::post('/loans', [LoanController::class, 'store']);
    Route::post('/scheduled-repayments/{uuid}/repayments', [RepaymentController::class, 'store']);
});
