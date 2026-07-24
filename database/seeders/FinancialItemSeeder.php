<?php

namespace Database\Seeders;

use App\Models\FinancialItem;
use App\Models\FinancialReport;
use Illuminate\Database\Seeder;

class FinancialItemSeeder extends Seeder
{
    public function run(): void
    {
        $reports = FinancialReport::query()->get();

        foreach ($reports as $index => $report) {
            FinancialItem::updateOrCreate(
                [
                    'financial_report_id' => $report->id,
                    'description' => 'Item ' . ($index + 1),
                ],
                [
                    'type' => $index % 2 === 0 ? 'Income' : 'Expense',
                    'description' => 'Item ' . ($index + 1),
                    'quantity' => 1,
                    'unit_price' => 5000000 + ($index * 1000000),
                    'subtotal' => 5000000 + ($index * 1000000),
                    'transaction_date' => now()->subDays(5)->toDateString(),
                ]
            );
        }
    }
}
