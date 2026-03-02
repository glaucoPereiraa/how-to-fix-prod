<?php

use Illuminate\Support\Facades\Route;

Route::post('/buy', [App\Http\Controllers\BuyController::class, 'store'])->name('buy.store');