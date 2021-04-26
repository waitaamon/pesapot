<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('auth.login'));

Route::group(['middleware' => ['auth']], function () {

    Route::get('dashboard', \App\Http\Controllers\HomeController::class)->name('dashboard');
});

require __DIR__.'/auth.php';
