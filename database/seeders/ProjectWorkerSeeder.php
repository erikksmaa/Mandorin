<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectWorker;
use Illuminate\Database\Seeder;

class ProjectWorkerSeeder extends Seeder
{
    public function run(): void
    {
        $workers = [

            'Renovasi Rumah Minimalis' => [
                [
                    'name' => 'Slamet Riyadi',
                    'role' => 'Tukang Bangunan',
                ],
                [
                    'name' => 'Joko Susilo',
                    'role' => 'Tukang Cat',
                ],
                [
                    'name' => 'Yanto',
                    'role' => 'Helper',
                ],
            ],

            'Pemasangan Plafon PVC' => [
                [
                    'name' => 'Agus Salim',
                    'role' => 'Tukang Plafon',
                ],
                [
                    'name' => 'Bambang',
                    'role' => 'Helper',
                ],
            ],

            'Bangun Garasi Mobil' => [
                [
                    'name' => 'Roni',
                    'role' => 'Tukang Bangunan',
                ],
                [
                    'name' => 'Tono',
                    'role' => 'Helper',
                ],
            ],

            'Renovasi Dapur' => [
                [
                    'name' => 'Wawan',
                    'role' => 'Tukang Interior',
                ],
                [
                    'name' => 'Imam',
                    'role' => 'Helper',
                ],
            ],

            'Pengecatan Rumah' => [
                [
                    'name' => 'Dedi',
                    'role' => 'Tukang Cat',
                ],
                [
                    'name' => 'Arif',
                    'role' => 'Helper',
                ],
            ],

        ];

        foreach ($workers as $projectTitle => $team) {

            $project = Project::where('title', $projectTitle)->first();

            if (!$project) {
                continue;
            }

            foreach ($team as $worker) {

                ProjectWorker::updateOrCreate(
                    [
                        'project_id' => $project->id,
                        'name' => $worker['name'],
                    ],
                    [
                        'project_id' => $project->id,
                        'name' => $worker['name'],
                        'role' => $worker['role'],
                    ]
                );

            }

        }
    }
}