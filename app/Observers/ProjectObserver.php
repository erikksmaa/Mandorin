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

            // Ambil nomor urut terbanyak yang pernah dipakai
            $count = Project::withTrashed()
                ->where('project_code', 'like', $prefix . '%')
                ->count();

            $nextNumber = $count + 1;

            // Loop untuk menjamin tidak ada duplikasi kode (unique constraint)
            do {
                $code = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                $exists = Project::withTrashed()->where('project_code', $code)->exists();
                if ($exists) {
                    $nextNumber++;
                }
            } while ($exists);

            $project->project_code = $code;
        }
    }
}
