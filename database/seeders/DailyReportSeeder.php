<?php

namespace Database\Seeders;

use App\Models\DailyReport;
use App\Models\Project;
use Illuminate\Database\Seeder;

class DailyReportSeeder extends Seeder
{
    public function run(): void
    {
        $reports = [

            'Renovasi Rumah Minimalis' => [
                [
                    'date' => '2026-07-01',
                    'progress_percentage' => 20,
                    'description' => 'Pembongkaran bagian depan rumah dan persiapan material.',
                ],
                [
                    'date' => '2026-07-02',
                    'progress_percentage' => 45,
                    'description' => 'Pemasangan dinding dan perbaikan struktur bangunan.',
                ],
                [
                    'date' => '2026-07-03',
                    'progress_percentage' => 70,
                    'description' => 'Pengerjaan lantai dan pengecatan dasar.',
                ],
                [
                    'date' => '2026-07-04',
                    'progress_percentage' => 90,
                    'description' => 'Finishing interior dan pembersihan area.',
                ],
                [
                    'date' => '2026-07-05',
                    'progress_percentage' => 100,
                    'description' => 'Proyek selesai dan siap diserahterimakan.',
                ],
            ],

            'Pemasangan Plafon PVC' => [
                [
                    'date' => '2026-07-01',
                    'progress_percentage' => 15,
                    'description' => 'Persiapan rangka plafon.',
                ],
                [
                    'date' => '2026-07-02',
                    'progress_percentage' => 35,
                    'description' => 'Pemasangan rangka utama.',
                ],
                [
                    'date' => '2026-07-03',
                    'progress_percentage' => 50,
                    'description' => 'Pemasangan panel PVC.',
                ],
                [
                    'date' => '2026-07-04',
                    'progress_percentage' => 65,
                    'description' => 'Finishing sudut dan lis plafon.',
                ],
            ],

        ];

        foreach ($reports as $projectTitle => $items) {

            $project = Project::where('title', $projectTitle)->first();

            if (!$project) {
                continue;
            }

            foreach ($items as $item) {

                DailyReport::updateOrCreate(
                    [
                        'project_id' => $project->id,
                        'date' => $item['date'],
                    ],
                    [
                        'created_by' => $project->contractor_id,
                        'progress_percentage' => $item['progress_percentage'],
                        'notes' => $item['description'],
                        'before_photo' => null,
                        'after_photo' => null,
                    ]
                );

            }

        }
    }
}