<?php

namespace Database\Seeders;

use App\Enums\ActivityStatus;
use App\Models\ActivityLog;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        $programs = Program::query()->get();
        $creator = User::where('email', 'leader@sipora.id')->first();

        foreach ($programs as $index => $program) {
            ActivityLog::updateOrCreate(
                [
                    'program_id' => $program->id,
                    'title' => 'Kegiatan ' . ($index + 1),
                ],
                [
                    'created_by' => $creator?->id ?? 1,
                    'description' => 'Aktivitas pelaksanaan program.',
                    'activity_date' => now()->subDays(3)->toDateString(),
                    'progress_percentage' => 60 + $index,
                    'issues' => 'Kendala koordinasi ringan.',
                    'solutions' => 'Dilakukan evaluasi bersama.',
                    'status' => ActivityStatus::Submitted->value,
                ]
            );
        }
    }
}
