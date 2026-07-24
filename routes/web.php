<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('home');

Route::name('public.')->group(function () {
    Route::get('/organisasi', \App\Livewire\Public\OrganizationIndex::class)->name('organizations.index');
    Route::get('/organisasi/{organization}', \App\Livewire\Public\OrganizationShow::class)->name('organizations.show');

    Route::get('/program', \App\Livewire\Public\ProgramIndex::class)->name('programs.index');
    Route::get('/program/{program}', \App\Livewire\Public\ProgramShow::class)->name('programs.show');

    Route::get('/galeri', \App\Livewire\Public\PortfolioIndex::class)->name('gallery.index');

    Route::get('/search', \App\Livewire\Public\SearchResults::class)->name('search');
});

/*
|--------------------------------------------------------------------------
| Role-Based Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/admin.php';
require __DIR__.'/verifier.php';
require __DIR__.'/leader.php';

/*
|--------------------------------------------------------------------------
| Profile (shared)
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