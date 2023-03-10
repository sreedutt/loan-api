<?php

namespace App\Admin\Routes;

use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\LoanController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/loans/{uuid}/approve', [LoanController::class, 'approveLoan']);
});
