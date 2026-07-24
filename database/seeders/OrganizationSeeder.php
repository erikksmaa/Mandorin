<?php

namespace Database\Seeders;

use App\Enums\OrganizationStatus;
use App\Models\Organization;
use App\Models\OrganizationCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $creator = User::where('email', 'admin@sipora.id')->first();
        $category = OrganizationCategory::first();

        $organizations = [
            [
                'organization_code' => 'ORG-001',
                'name' => 'Karang Taruna Desa Suka Maju',
                'slug' => 'karang-taruna-desa-suka-maju',
                'description' => 'Organisasi pemuda desa yang fokus pada kegiatan sosial dan kebersamaan.',
                'address' => 'Desa Suka Maju',
                'phone' => '081100000001',
                'email' => 'info@karangtaruna.id',
                'website' => 'https://karangtaruna.id',
            ],
            [
                'organization_code' => 'ORG-002',
                'name' => 'Komunitas Belajar Pemuda',
                'slug' => 'komunitas-belajar-pemuda',
                'description' => 'Komunitas pemuda yang bergerak di bidang edukasi dan pelatihan.',
                'address' => 'Kota Maju',
                'phone' => '081100000002',
                'email' => 'komunitas@pemuda.id',
                'website' => 'https://pemuda.id',
            ],
        ];

        foreach ($organizations as $organization) {
            Organization::updateOrCreate(
                ['organization_code' => $organization['organization_code']],
                [
                    'category_id' => $category?->id ?? 1,
                    'created_by' => $creator?->id ?? 1,
                    'organization_code' => $organization['organization_code'],
                    'name' => $organization['name'],
                    'slug' => $organization['slug'],
                    'description' => $organization['description'],
                    'address' => $organization['address'],
                    'phone' => $organization['phone'],
                    'email' => $organization['email'],
                    'website' => $organization['website'],
                    'status' => OrganizationStatus::Active->value,
                ]
            );
        }
    }
}
