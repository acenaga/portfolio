<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::view('portfolio', 'portfolio')->name('portfolio');
Route::view('mockup', 'mockup')->name('mockup');

require __DIR__.'/settings.php';
