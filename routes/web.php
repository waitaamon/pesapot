<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('auth.login'));

Route::get('debug', [\App\Http\Controllers\Api\CustomersController::class, 'index']);

Route::group(['middleware' => ['auth']], function () {

    Route::get('dashboard', \App\Http\Controllers\HomeController::class)->name('dashboard');

    Route::get('customers', [App\Http\Controllers\CustomersController::class, 'index'])->name('customersIndex');
    Route::get('customers/{id}', [App\Http\Controllers\CustomersController::class, 'show'])->name('customersShow');

    Route::apiResource('api/customers', \App\Http\Controllers\Api\CustomersController::class);

    Route::get('cash-receipts', \App\Http\Controllers\CashReceiptsController::class)->name('cashReceipt');

    Route::get('api/cash-receipt-prerequisites', [\App\Http\Controllers\Api\CashReceiptsController::class, 'prerequisites']);
    Route::post('api/cash-receipt-mark-transferred', [\App\Http\Controllers\Api\CashReceiptActionsController::class, 'markTransferred']);
    Route::post('api/cash-receipt-export-excel', [\App\Http\Controllers\Api\CashReceiptActionsController::class, 'exportExcel']);
    Route::apiResource('api/cash-receipts', \App\Http\Controllers\Api\CashReceiptsController::class);

});

require __DIR__.'/auth.php';
