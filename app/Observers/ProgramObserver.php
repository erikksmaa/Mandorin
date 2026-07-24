<?php

namespace App\Observers;

use App\Models\Notification;
use App\Models\Program;
use Illuminate\Support\Str;

class ProgramObserver
{
    /**
     * Auto-generate program_code and slug before Program is created.
     * Format Code: PRG-YYYYMM-NNN (e.g. PRG-202607-001)
     */
    public function creating(Program $program): void
    {
        if (empty($program->program_code)) {
            $prefix = 'PRG-' . now()->format('Ym') . '-';

            $count = Program::withTrashed()
                ->where('program_code', 'like', $prefix . '%')
                ->count();

            $nextNumber = $count + 1;

            do {
                $code = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                $exists = Program::withTrashed()->where('program_code', $code)->exists();
                if ($exists) {
                    $nextNumber++;
                }
            } while ($exists);

            $program->program_code = $code;
        }

        if (empty($program->slug)) {
            $baseSlug = Str::slug($program->title);
            $slug = $baseSlug;
            $count = 1;

            while (Program::withTrashed()->where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }

            $program->slug = $slug;
        }
    }

    public function updating(Program $program): void
    {
        if ($program->isDirty('title') && empty($program->slug)) {
            $baseSlug = Str::slug($program->title);
            $slug = $baseSlug;
            $count = 1;

            while (Program::withTrashed()->where('slug', $slug)->where('id', '!=', $program->id)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }

            $program->slug = $slug;
        }
    }

    public function updated(Program $program): void
    {
        // Notification on proposal_status change
        if ($program->isDirty('proposal_status')) {
            $newStatus = $program->proposal_status->value ?? $program->proposal_status;

            Notification::create([
                'user_id' => $program->leader_id,
                'title' => 'Status Proposal Diperbarui',
                'message' => "Proposal program '{$program->title}' telah diubah menjadi: {$newStatus}",
                'type' => \App\Enums\NotificationType::System,
                'reference_id' => $program->id,
            ]);
        }
    }
}
