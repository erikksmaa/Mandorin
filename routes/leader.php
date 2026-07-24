<?php

use App\Livewire\Leader\ActivityLogForm;
use App\Livewire\Leader\AttendanceForm;
use App\Livewire\Leader\Dashboard;
use App\Livewire\Leader\ElpjForm;
use App\Livewire\Leader\MemberManager;
use App\Livewire\Leader\OrganizationProfile;
use App\Livewire\Leader\ProgramDetail;
use App\Livewire\Leader\ProgramIndex;
use App\Livewire\Leader\ProposalForm;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:leader'])
    ->prefix('leader')
    ->name('leader.')
    ->group(function () {

        Route::get('/dashboard', Dashboard::class)
            ->name('dashboard');

        Route::get('/profil-organisasi', OrganizationProfile::class)
            ->name('profile.show');

        Route::get('/program', ProgramIndex::class)
            ->name('programs.index');

        Route::get('/program/ajukan', ProposalForm::class)
            ->name('programs.create');

        Route::get('/program/{program}/edit', ProposalForm::class)
            ->name('programs.edit');

        Route::get('/program/{program}', ProgramDetail::class)
            ->name('programs.show');

        Route::get('/program/{program}/logbook', ActivityLogForm::class)
            ->name('logbook.create');

        Route::get('/logbook/{activityLog}', \App\Livewire\Leader\ActivityLogDetail::class)
            ->name('logbook.show');

        Route::get('/organisasi/anggota', MemberManager::class)
            ->name('members.index');

        Route::get('/program/{program}/absensi', AttendanceForm::class)
            ->name('attendance.index');

        Route::get('/program/{program}/e-lpj', ElpjForm::class)
            ->name('elpj.form');

    });
