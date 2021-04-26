<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('auth.login'));

Route::get('debug', [\App\Http\Controllers\Api\CustomersController::class, 'index']);

Route::group(['middleware' => ['auth']], function () {

    Route::get('dashboard', \App\Http\Controllers\HomeController::class)->name('dashboard');

    Route::get('customers', \App\Http\Controllers\CustomersController::class)->name('customers');
    Route::apiResource('api/customers', \App\Http\Controllers\Api\CustomersController::class);

    Route::get('cash-receipts', \App\Http\Controllers\CashReceiptsController::class)->name('cashReceipt');

    Route::get('api/cash-receipt-prerequisites', [\App\Http\Controllers\Api\CashReceiptsController::class, 'prerequisites']);
    Route::apiResource('api/cash-receipts', \App\Http\Controllers\Api\CashReceiptsController::class);

});

require __DIR__.'/auth.php';
