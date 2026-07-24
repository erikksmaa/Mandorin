<?php

namespace Database\Seeders;

use App\Enums\FinancialStatus;
use App\Models\FinancialReport;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;

class FinancialReportSeeder extends Seeder
{
    public function run(): void
    {
        $programs = Program::query()->get();
        $verifier = User::where('email', 'verifikator@sipora.id')->first();

        foreach ($programs as $index => $program) {
            FinancialReport::updateOrCreate(
                ['program_id' => $program->id],
                [
                    'verified_by' => $verifier?->id,
                    'report_number' => 'FR-' . str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                    'total_budget' => 15000000 + ($index * 5000000),
                    'total_income' => 10000000 + ($index * 2000000),
                    'total_expense' => 8000000 + ($index * 1500000),
                    'remaining_budget' => 7000000 + ($index * 500000),
                    'status' => FinancialStatus::Draft->value,
                ]
            );
        }
    }
}
