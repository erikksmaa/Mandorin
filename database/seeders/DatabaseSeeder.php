<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            OrganizationCategorySeeder::class,
            ProgramCategorySeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            OrganizationSeeder::class,
            OrganizationMemberSeeder::class,
            ProgramSeeder::class,
            ProgramMemberSeeder::class,
            ActivityLogSeeder::class,
            ActivityPhotoSeeder::class,
            AttendanceSeeder::class,
            FinancialReportSeeder::class,
            FinancialItemSeeder::class,
        ]);
    }
}
