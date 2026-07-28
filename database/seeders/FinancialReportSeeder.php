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
        $users = User::pluck('id', 'email');

        $verifier1 = $users['siti.rahayu@sipora.id'];
        $verifier2 = $users['budi.santoso@sipora.id'];

        // program_code => report data
        $reports = [
            'PRG-001' => [
                'report_number'    => 'LPJ-2024-001',
                'total_budget'     => 18500000,
                'total_income'     => 0,
                'total_expense'    => 0,
                'remaining_budget' => 18500000,
                'status'           => FinancialStatus::Draft,
                'verified_by'      => null,
                'submitted_at'     => null,
                'verified_at'      => null,
            ],
            'PRG-002' => [
                'report_number'    => 'LPJ-2024-002',
                'total_budget'     => 22000000,
                'total_income'     => 0,
                'total_expense'    => 0,
                'remaining_budget' => 22000000,
                'status'           => FinancialStatus::Draft,
                'verified_by'      => null,
                'submitted_at'     => null,
                'verified_at'      => null,
            ],
            'PRG-003' => [
                'report_number'    => 'LPJ-2024-003',
                'total_budget'     => 15000000,
                'total_income'     => 15000000,
                'total_expense'    => 13850000,
                'remaining_budget' => 1150000,
                'status'           => FinancialStatus::Submitted,
                'verified_by'      => null,
                'submitted_at'     => '2024-02-20 10:00:00',
                'verified_at'      => null,
            ],
            'PRG-004' => [
                'report_number'    => 'LPJ-2024-004',
                'total_budget'     => 28000000,
                'total_income'     => 28000000,
                'total_expense'    => 25700000,
                'remaining_budget' => 2300000,
                'status'           => FinancialStatus::Revision,
                'verified_by'      => $verifier1,
                'submitted_at'     => '2024-03-25 14:00:00',
                'verified_at'      => '2024-03-28 10:00:00',
            ],
            'PRG-005' => [
                'report_number'    => 'LPJ-2024-005',
                'total_budget'     => 12500000,
                'total_income'     => 12500000,
                'total_expense'    => 11750000,
                'remaining_budget' => 750000,
                'status'           => FinancialStatus::Approved,
                'verified_by'      => $verifier1,
                'submitted_at'     => '2024-03-05 09:00:00',
                'verified_at'      => '2024-03-10 11:00:00',
            ],
            'PRG-006' => [
                'report_number'    => 'LPJ-2024-006',
                'total_budget'     => 8500000,
                'total_income'     => 8500000,
                'total_expense'    => 7900000,
                'remaining_budget' => 600000,
                'status'           => FinancialStatus::Approved,
                'verified_by'      => $verifier2,
                'submitted_at'     => '2024-03-15 10:00:00',
                'verified_at'      => '2024-03-18 09:00:00',
            ],
            'PRG-007' => [
                'report_number'    => 'LPJ-2024-007',
                'total_budget'     => 35000000,
                'total_income'     => 35000000,
                'total_expense'    => 32500000,
                'remaining_budget' => 2500000,
                'status'           => FinancialStatus::Submitted,
                'verified_by'      => null,
                'submitted_at'     => '2024-02-18 10:00:00',
                'verified_at'      => null,
            ],
            'PRG-008' => [
                'report_number'    => 'LPJ-2024-008',
                'total_budget'     => 25000000,
                'total_income'     => 25000000,
                'total_expense'    => 18500000,
                'remaining_budget' => 6500000,
                'status'           => FinancialStatus::Draft,
                'verified_by'      => null,
                'submitted_at'     => null,
                'verified_at'      => null,
            ],
            'PRG-009' => [
                'report_number'    => 'LPJ-2023-009',
                'total_budget'     => 32000000,
                'total_income'     => 32000000,
                'total_expense'    => 30750000,
                'remaining_budget' => 1250000,
                'status'           => FinancialStatus::Approved,
                'verified_by'      => $verifier1,
                'submitted_at'     => '2023-10-30 09:00:00',
                'verified_at'      => '2023-11-05 10:00:00',
            ],
            'PRG-010' => [
                'report_number'    => 'LPJ-2023-010',
                'total_budget'     => 45000000,
                'total_income'     => 45000000,
                'total_expense'    => 43200000,
                'remaining_budget' => 1800000,
                'status'           => FinancialStatus::Approved,
                'verified_by'      => $verifier2,
                'submitted_at'     => '2023-11-25 10:00:00',
                'verified_at'      => '2023-12-01 09:00:00',
            ],
        ];

        foreach ($reports as $programCode => $report) {
            $program = Program::where('program_code', $programCode)->first();
            if (! $program) {
                continue;
            }

            FinancialReport::updateOrCreate(
                ['program_id' => $program->id],
                [
                    'verified_by'      => $report['verified_by'],
                    'report_number'    => $report['report_number'],
                    'total_budget'     => $report['total_budget'],
                    'total_income'     => $report['total_income'],
                    'total_expense'    => $report['total_expense'],
                    'remaining_budget' => $report['remaining_budget'],
                    'status'           => $report['status'],
                    'submitted_at'     => $report['submitted_at'],
                    'verified_at'      => $report['verified_at'],
                ]
            );
        }
    }
}