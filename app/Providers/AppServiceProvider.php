<?php

namespace App\Providers;

use App\Models\FinancialReport;
use App\Models\Organization;
use App\Models\Program;
use App\Observers\FinancialReportObserver;
use App\Observers\OrganizationObserver;
use App\Observers\ProgramObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register SIPORA Observers
        Organization::observe(OrganizationObserver::class);
        Program::observe(ProgramObserver::class);
        FinancialReport::observe(FinancialReportObserver::class);
    }
}
