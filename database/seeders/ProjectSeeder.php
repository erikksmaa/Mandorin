<?php

namespace Database\Seeders;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [

            [
                'customer' => 'ahmad@mandorin.test',
                'contractor' => 'budi@mandorin.test',
                'service' => 'Renovasi Rumah',

                'title' => 'Renovasi Rumah Minimalis',
                'description' => 'Renovasi rumah tipe 45 menjadi konsep minimalis modern.',
                'address' => 'Jl. Melati No. 10, Pekalongan',

                'status' => ProjectStatus::Completed,
                'progress_percentage' => 100,
            ],

            [
                'customer' => 'siti@mandorin.test',
                'contractor' => 'andi@mandorin.test',
                'service' => 'Plafon',

                'title' => 'Pemasangan Plafon PVC',
                'description' => 'Pemasangan plafon PVC untuk ruang tamu dan dapur.',
                'address' => 'Jl. Mawar No. 5, Pemalang',

                'status' => ProjectStatus::InProgress,
                'progress_percentage' => 65,
            ],

            [
                'customer' => 'dimas@mandorin.test',
                'contractor' => 'rudi@mandorin.test',
                'service' => 'Bangun Rumah',

                'title' => 'Bangun Garasi Mobil',
                'description' => 'Pembangunan garasi berukuran 6 x 4 meter.',
                'address' => 'Jl. Kenanga No. 15, Tegal',

                'status' => ProjectStatus::Pending,
                'progress_percentage' => 0,
            ],

            [
                'customer' => 'nabila@mandorin.test',
                'contractor' => 'budi@mandorin.test',
                'service' => 'Interior',

                'title' => 'Renovasi Dapur',
                'description' => 'Renovasi dapur bergaya Scandinavian.',
                'address' => 'Jl. Cempaka No. 8, Pekalongan',

                'status' => ProjectStatus::Accepted,
                'progress_percentage' => 0,
            ],

            [
                'customer' => 'rizky@mandorin.test',
                'contractor' => 'andi@mandorin.test',
                'service' => 'Pengecatan',

                'title' => 'Pengecatan Rumah',
                'description' => 'Pengecatan ulang rumah dua lantai.',
                'address' => 'Jl. Anggrek No. 20, Batang',

                'status' => ProjectStatus::Cancelled,
                'progress_percentage' => 0,
            ],

        ];

        foreach ($projects as $index => $project) {

            $customer = User::where('email', $project['customer'])->first();
            $contractor = User::where('email', $project['contractor'])->first();
            $service = Service::where('name', $project['service'])->first();

            if (!$customer || !$contractor || !$service) {
                continue;
            }

            $requestedAt = now()->subDays(10 - $index);

            $startDate = match ($project['status']) {
                ProjectStatus::Accepted,
                ProjectStatus::InProgress,
                ProjectStatus::Completed => now()->subDays(8 - $index)->toDateString(),
                default => null,
            };

            $estimatedFinishDate = match ($project['status']) {
                ProjectStatus::Accepted,
                ProjectStatus::InProgress,
                ProjectStatus::Completed => now()->addDays(7)->toDateString(),
                default => null,
            };

            $completedAt = $project['status'] === ProjectStatus::Completed
                ? now()->subDays(1)
                : null;

            Project::updateOrCreate(

                [
                    'project_code' => sprintf(
                        'PRJ-%s-%03d',
                        now()->format('Ym'),
                        $index + 1
                    ),
                ],

                [
                    'customer_id' => $customer->id,
                    'contractor_id' => $contractor->id,
                    'service_id' => $service->id,

                    'title' => $project['title'],
                    'description' => $project['description'],
                    'address' => $project['address'],

                    'requested_at' => $requestedAt,
                    'start_date' => $startDate,
                    'estimated_finish_date' => $estimatedFinishDate,
                    'completed_at' => $completedAt,

                    'status' => $project['status'],
                    'progress_percentage' => $project['progress_percentage'],
                ]

            );
        }
    }
}