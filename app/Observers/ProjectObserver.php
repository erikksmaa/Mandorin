<?php

namespace App\Observers;

use App\Models\Project;
use Illuminate\Support\Str;

class ProjectObserver
{
    /**
     * Auto-generate project_code sebelum Project disimpan.
     * Format: PRJ-YYYYMM-NNN (nomor urut 3 digit per bulan)
     *
     * Contoh: PRJ-202507-001, PRJ-202507-002, dst.
     */
    public function creating(Project $project): void
    {
        if (empty($project->project_code)) {
            $prefix = 'PRJ-' . now()->format('Ym') . '-';

            // Hitung berapa project yang sudah ada bulan ini
            $count = Project::withTrashed()
                ->where('project_code', 'like', $prefix . '%')
                ->count();

            $project->project_code = $prefix . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        }
    }
}
