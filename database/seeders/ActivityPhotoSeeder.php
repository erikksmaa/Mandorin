<?php

namespace Database\Seeders;

use App\Enums\PhotoType;
use App\Models\ActivityLog;
use App\Models\ActivityPhoto;
use Illuminate\Database\Seeder;

class ActivityPhotoSeeder extends Seeder
{
    public function run(): void
    {
        $activityLogs = ActivityLog::query()->get();

        foreach ($activityLogs as $index => $activityLog) {
            ActivityPhoto::updateOrCreate(
                [
                    'activity_log_id' => $activityLog->id,
                    'photo' => 'photos/' . ($index + 1) . '.jpg',
                ],
                [
                    'caption' => 'Dokumentasi kegiatan ' . ($index + 1),
                    'photo_type' => $index === 0 ? PhotoType::Before->value : PhotoType::Progress->value,
                ]
            );
        }
    }
}
