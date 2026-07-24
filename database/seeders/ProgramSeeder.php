<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $organization = Organization::query()->first();
        $leader = User::where('email', 'leader@sipora.id')->first();
        $creator = User::where('email', 'admin@sipora.id')->first();
        $verifier = User::where('email', 'verifikator@sipora.id')->first();
        $category = ProgramCategory::first();

        if (! $organization || ! $leader || ! $creator || ! $category) {
            return;
        }

        $programs = [
            [
                'program_code' => 'PRG-001',
                'title' => 'Program Pelatihan Kepemudaan',
                'slug' => 'program-pelatihan-kepemudaan',
                'description' => 'Program pelatihan kepemudaan untuk penguatan soft skills.',
                'objective' => 'Meningkatkan kapasitas pemuda lokal.',
                'target' => '30 peserta pemuda desa.',
                'location' => 'Balai Desa Suka Maju',
                'budget' => 15000000,
                'proposal_status' => 'Pending',
                'status' => 'Draft',
            ],
            [
                'program_code' => 'PRG-002',
                'title' => 'Program Kegiatan Sosial',
                'slug' => 'program-kegiatan-sosial',
                'description' => 'Program kegiatan sosial berbasis gotong royong.',
                'objective' => 'Membantu kebutuhan warga sekitar.',
                'target' => '50 warga',
                'location' => 'Lingkungan Desa Suka Maju',
                'budget' => 20000000,
                'proposal_status' => 'Verified',
                'status' => 'Approved',
            ],
        ];

        foreach ($programs as $program) {
            Program::updateOrCreate(
                ['program_code' => $program['program_code']],
                [
                    'organization_id' => $organization->id,
                    'leader_id' => $leader->id,
                    'category_id' => $category->id,
                    'created_by' => $creator->id,
                    'verified_by' => $verifier?->id,
                    'program_code' => $program['program_code'],
                    'title' => $program['title'],
                    'slug' => $program['slug'],
                    'description' => $program['description'],
                    'objective' => $program['objective'],
                    'target' => $program['target'],
                    'location' => $program['location'],
                    'budget' => $program['budget'],
                    'proposal_status' => $program['proposal_status'],
                    'status' => $program['status'],
                    'start_date' => now()->subDays(10)->toDateString(),
                    'end_date' => now()->addDays(20)->toDateString(),
                ]
            );
        }
    }
}
