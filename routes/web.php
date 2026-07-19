<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('home');

/*
|--------------------------------------------------------------------------
| Role-Based Routes (dipisah ke file masing-masing)
|--------------------------------------------------------------------------
*/

require __DIR__.'/admin.php';
require __DIR__.'/contractor.php';
require __DIR__.'/customer.php';

/*
|--------------------------------------------------------------------------
| Profile (shared, semua role yang sudah auth)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::view('/profile', 'profile')->name('profile');

});

/*
|--------------------------------------------------------------------------
| Authentication (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';