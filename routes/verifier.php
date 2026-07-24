<?php

use App\Livewire\Verifier\Dashboard;
use App\Livewire\Verifier\ElpjVerification;
use App\Livewire\Verifier\ProgramEvaluation;
use App\Livewire\Verifier\ProposalDetail;
use App\Livewire\Verifier\ProposalIndex;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:verifikator,verifier'])
    ->prefix('verifier')
    ->name('verifier.')
    ->group(function () {

        Route::get('/dashboard', Dashboard::class)
            ->name('dashboard');

        Route::get('/proposal-masuk', ProposalIndex::class)
            ->name('proposals.index');

        Route::get('/proposal/{program}', ProposalDetail::class)
            ->name('proposals.show');

        Route::get('/verifikasi-elpj', ElpjVerification::class)
            ->name('elpj.index');

        Route::get('/logbook', \App\Livewire\Verifier\LogbookMonitoring::class)
            ->name('logbook.index');

        Route::get('/logbook/{activityLog}', \App\Livewire\Leader\ActivityLogDetail::class)
            ->name('logbook.show');

        Route::get('/evaluasi/{program}', ProgramEvaluation::class)
            ->name('evaluation.show');

    });
