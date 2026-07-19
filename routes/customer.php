<?php

use App\Livewire\Customer\ContractorProfile;
use App\Livewire\Customer\ContractorSearch;
use App\Livewire\Customer\Dashboard;
use App\Livewire\Customer\HireForm;
use App\Livewire\Customer\MyProjects;
use App\Livewire\Customer\ProjectDetail;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', Dashboard::class)
            ->name('dashboard');

        Route::get('/cari-kontraktor', ContractorSearch::class)
            ->name('contractors.index');

        Route::get('/kontraktor/{contractorProfile}', ContractorProfile::class)
            ->name('contractors.show');

        Route::get('/sewa/{contractorProfile}', HireForm::class)
            ->name('hire.create');

        Route::get('/proyek-saya', MyProjects::class)
            ->name('projects.index');

        Route::get('/proyek/{project}', ProjectDetail::class)
            ->name('projects.show');

    });
