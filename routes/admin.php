<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\OrganizationCategoryManagement;
use App\Livewire\Admin\OrganizationVerificationDetail;
use App\Livewire\Admin\OrganizationVerificationQueue;
use App\Livewire\Admin\ProgramCategoryManagement;
use App\Livewire\Admin\UserManagement;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:administrator,admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', Dashboard::class)
            ->name('dashboard');

        Route::get('/verifikasi-organisasi', OrganizationVerificationQueue::class)
            ->name('verification.index');

        Route::get('/verifikasi-organisasi/{organization}', OrganizationVerificationDetail::class)
            ->name('verification.show');

        Route::get('/pengguna', UserManagement::class)
            ->name('users.index');

        Route::get('/kategori-program', ProgramCategoryManagement::class)
            ->name('categories.index');

        Route::get('/kategori-organisasi', OrganizationCategoryManagement::class)
            ->name('org_categories.index');

    });
