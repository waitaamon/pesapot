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
    Route::post('api/cash-receipt-delete', [\App\Http\Controllers\Api\CashReceiptActionsController::class, 'destroy']);
    Route::apiResource('api/cash-receipts', \App\Http\Controllers\Api\CashReceiptsController::class);


    Route::get('suppliers', [App\Http\Controllers\SuppliersController::class, 'index'])->name('suppliersIndex');
    Route::get('suppliers/{id}', [App\Http\Controllers\SuppliersController::class, 'show'])->name('suppliersShow');

    Route::apiResource('api/suppliers', \App\Http\Controllers\Api\SuppliersController::class);

    Route::get('cash-payment', \App\Http\Controllers\CashPaymentsController::class)->name('cashPayment');

    Route::get('api/cash-payment-prerequisites', [\App\Http\Controllers\Api\CashPaymentsController::class, 'prerequisites']);
    Route::post('api/cash-payment-mark-transferred', [\App\Http\Controllers\Api\CashPaymentActionsController::class, 'markTransferred']);
    Route::post('api/cash-payment-export-excel', [\App\Http\Controllers\Api\CashPaymentActionsController::class, 'exportExcel']);
    Route::post('api/cash-payment-delete', [\App\Http\Controllers\Api\CashPaymentActionsController::class, 'destroy']);
    Route::apiResource('api/cash-payments', \App\Http\Controllers\Api\CashPaymentsController::class);

});

require __DIR__.'/auth.php';
