<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            OrganizationCategorySeeder::class,
            OrganizationSeeder::class,
            OrganizationMemberSeeder::class,
            ProgramCategorySeeder::class,
            ProgramSeeder::class,
            ProgramMemberSeeder::class,
            AttendanceSeeder::class,
            ActivityLogSeeder::class,
            ActivityPhotoSeeder::class,
            FinancialReportSeeder::class,
            FinancialItemSeeder::class,
        ]);
    }
}