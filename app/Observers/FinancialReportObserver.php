<?php

namespace App\Observers;

use App\Models\FinancialReport;
use App\Models\Notification;

class FinancialReportObserver
{
    /**
     * Auto-generate report_number before FinancialReport is created.
     * Format: LPJ-YYYYMM-NNN
     */
    public function creating(FinancialReport $report): void
    {
        if (empty($report->report_number)) {
            $prefix = 'LPJ-' . now()->format('Ym') . '-';

            $count = FinancialReport::where('report_number', 'like', $prefix . '%')->count();
            $nextNumber = $count + 1;

            do {
                $number = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                $exists = FinancialReport::where('report_number', $number)->exists();
                if ($exists) {
                    $nextNumber++;
                }
            } while ($exists);

            $report->report_number = $number;
        }
    }

    public function updated(FinancialReport $report): void
    {
        if ($report->isDirty('status') && $report->program) {
            $newStatus = $report->status->value ?? $report->status;

            Notification::create([
                'user_id' => $report->program->leader_id,
                'title' => 'Status E-LPJ Diperbarui',
                'message' => "Laporan Keuangan E-LPJ ({$report->report_number}) untuk program '{$report->program->title}' diubah menjadi: {$newStatus}",
                'type' => \App\Enums\NotificationType::System,
                'reference_id' => $report->id,
            ]);
        }
    }
}
