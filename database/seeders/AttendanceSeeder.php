<?php

namespace Database\Seeders;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\ProjectWorker;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $dates = [
            '2026-07-01',
            '2026-07-02',
            '2026-07-03',
            '2026-07-04',
            '2026-07-05',
        ];

        $workers = ProjectWorker::all();

        foreach ($workers as $worker) {

            foreach ($dates as $index => $date) {

                $status = match (true) {

                    // Hari ketiga beberapa pekerja izin
                    $index === 2 && in_array($worker->name, [
                        'Yanto',
                        'Bambang',
                    ]) => AttendanceStatus::Leave,

                    // Hari kelima satu pekerja tidak hadir
                    $index === 4 && $worker->name === 'Roni'
                    => AttendanceStatus::Absent,

                    default => AttendanceStatus::Present,
                };

                Attendance::updateOrCreate(
                    [
                        'project_worker_id' => $worker->id,
                        'date' => $date,
                    ],
                    [
                        'status' => $status,
                    ]
                );
            }
        }
    }
}