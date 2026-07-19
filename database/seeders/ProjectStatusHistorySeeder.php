<?php

namespace Database\Seeders;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\ProjectStatusHistory;
use Illuminate\Database\Seeder;

class ProjectStatusHistorySeeder extends Seeder
{
    public function run(): void
    {
        $histories = [

            'Renovasi Rumah Minimalis' => [

                [
                    'status' => ProjectStatus::Pending,
                    'created_at' => '2026-06-28 08:00:00',
                ],

                [
                    'status' => ProjectStatus::Accepted,
                    'created_at' => '2026-06-28 13:20:00',
                ],

                [
                    'status' => ProjectStatus::InProgress,
                    'created_at' => '2026-07-01 08:00:00',
                ],

                [
                    'status' => ProjectStatus::Completed,
                    'created_at' => '2026-07-05 16:30:00',
                ],

            ],

            'Pemasangan Plafon PVC' => [

                [
                    'status' => ProjectStatus::Pending,
                    'created_at' => '2026-06-30 09:00:00',
                ],

                [
                    'status' => ProjectStatus::Accepted,
                    'created_at' => '2026-06-30 14:00:00',
                ],

                [
                    'status' => ProjectStatus::InProgress,
                    'created_at' => '2026-07-01 08:30:00',
                ],

            ],

            'Bangun Garasi Mobil' => [

                [
                    'status' => ProjectStatus::Pending,
                    'created_at' => '2026-07-03 10:00:00',
                ],

            ],

            'Renovasi Dapur' => [

                [
                    'status' => ProjectStatus::Pending,
                    'created_at' => '2026-07-02 11:00:00',
                ],

                [
                    'status' => ProjectStatus::Accepted,
                    'created_at' => '2026-07-02 15:30:00',
                ],

            ],

            'Pengecatan Rumah' => [

                [
                    'status' => ProjectStatus::Pending,
                    'created_at' => '2026-07-01 09:00:00',
                ],

                [
                    'status' => ProjectStatus::Cancelled,
                    'created_at' => '2026-07-01 17:00:00',
                ],

            ],

        ];

        foreach ($histories as $projectTitle => $statuses) {

            $project = Project::where('title', $projectTitle)->first();

            if (!$project) {
                continue;
            }

            foreach ($statuses as $history) {

                ProjectStatusHistory::updateOrCreate(

                    [
                        'project_id' => $project->id,
                        'status' => $history['status'],
                    ],

                    [
                        'changed_by' => $project->contractor_id,
                        'created_at' => $history['created_at'],
                        'updated_at' => $history['created_at'],
                    ]

                );

            }

        }
    }
}