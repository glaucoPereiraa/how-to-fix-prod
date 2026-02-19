<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/delay', [App\Http\Controllers\DelayController::class, 'handle'])->name('delay');