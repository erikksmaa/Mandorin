<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\ServiceManagement;
use App\Livewire\Admin\UserManagement;
use App\Livewire\Admin\VerificationDetail;
use App\Livewire\Admin\VerificationQueue;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', Dashboard::class)
            ->name('dashboard');

        Route::get('/verifikasi', VerificationQueue::class)
            ->name('verification.index');

        Route::get('/verifikasi/{contractorProfile}', VerificationDetail::class)
            ->name('verification.show');

        Route::get('/pengguna', UserManagement::class)
            ->name('users.index');

        Route::get('/layanan', ServiceManagement::class)
            ->name('services.index');

    });
