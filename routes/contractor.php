<?php

use App\Livewire\Contractor\Dashboard;
use App\Livewire\Contractor\DailyReportForm;
use App\Livewire\Contractor\PortfolioForm;
use App\Livewire\Contractor\Profile;
use App\Livewire\Contractor\ProjectDetail;
use App\Livewire\Contractor\RequestDetail;
use App\Livewire\Contractor\WorkerForm;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:contractor'])
    ->prefix('contractor')
    ->name('contractor.')
    ->group(function () {

        Route::get('/dashboard', Dashboard::class)
            ->name('dashboard');

        Route::get('/permintaan/{project}', RequestDetail::class)
            ->name('requests.show');

        Route::get('/proyek/{project}', ProjectDetail::class)
            ->name('projects.show');

        // WorkerForm: {worker?} opsional — create jika null, edit jika ada
        Route::get('/proyek/{project}/pekerja/{worker?}', WorkerForm::class)
            ->name('workers.form');

        Route::get('/proyek/{project}/laporan', DailyReportForm::class)
            ->name('reports.create');

        Route::get('/profil', Profile::class)
            ->name('profile.show');

        Route::get('/portofolio/{portfolio?}', PortfolioForm::class)
            ->name('portfolio.form');

    });
