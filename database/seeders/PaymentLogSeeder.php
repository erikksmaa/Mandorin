<?php

namespace Database\Seeders;

use App\Enums\PaymentStatus;
use App\Models\PaymentLog;
use App\Models\Project;
use Illuminate\Database\Seeder;

class PaymentLogSeeder extends Seeder
{
    public function run(): void
    {
        $payments = [

            'Renovasi Rumah Minimalis' => [

                [
                    'payment_number' => 1,
                    'amount' => 10000000,
                    'payment_date' => '2026-07-01',
                    'status' => PaymentStatus::Confirmed,
                ],

                [
                    'payment_number' => 2,
                    'amount' => 15000000,
                    'payment_date' => '2026-07-03',
                    'status' => PaymentStatus::Confirmed,
                ],

                [
                    'payment_number' => 3,
                    'amount' => 5000000,
                    'payment_date' => '2026-07-05',
                    'status' => PaymentStatus::Confirmed,
                ],

            ],

            'Pemasangan Plafon PVC' => [

                [
                    'payment_number' => 1,
                    'amount' => 3500000,
                    'payment_date' => '2026-07-02',
                    'status' => PaymentStatus::Confirmed,
                ],

            ],

        ];

        foreach ($payments as $projectTitle => $items) {

            $project = Project::where('title', $projectTitle)->first();

            if (!$project) {
                continue;
            }

            foreach ($items as $item) {

                PaymentLog::updateOrCreate(

                    [
                        'project_id' => $project->id,
                        'payment_number' => $item['payment_number'],
                    ],

                    [
                        'amount' => $item['amount'],
                        'payment_date' => $item['payment_date'],
                        'status' => $item['status'],
                        'receipt' => null,
                    ]

                );

            }

        }
    }
}