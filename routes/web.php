<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'mockup')->name('mockup');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});




require __DIR__ . '/settings.php';
