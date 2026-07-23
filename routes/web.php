<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('home');

Route::name('public.')->group(function () {
    Route::get('/contractors', \App\Livewire\Public\ContractorIndex::class)->name('contractors.index');
    Route::get('/contractors/{contractor}', \App\Livewire\Public\ContractorShow::class)->name('contractors.show');
    
    Route::get('/portfolios', \App\Livewire\Public\PortfolioIndex::class)->name('portfolios.index');
    Route::get('/portfolios/{portfolio}', \App\Livewire\Public\PortfolioShow::class)->name('portfolios.show');
    
    Route::get('/search', \App\Livewire\Public\SearchResults::class)->name('search');
});

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