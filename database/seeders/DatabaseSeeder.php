<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ServiceSeeder::class,
            ContractorProfileSeeder::class,
            ContractorServiceSeeder::class,
            ProjectSeeder::class,
            ProjectWorkerSeeder::class,
            AttendanceSeeder::class,
            DailyReportSeeder::class,
            PaymentLogSeeder::class,
            ProjectStatusHistorySeeder::class,
            PortfolioSeeder::class,
            ReviewSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}