<?php

namespace Database\Seeders;

use App\Models\OrganizationCategory;
use Illuminate\Database\Seeder;

class OrganizationCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Karang Taruna',
                'description' => 'Karang Taruna Desa',
            ],
            [
                'name' => 'Komunitas',
                'description' => 'Komunitas Pemuda',
            ],
            [
                'name' => 'Organisasi Kepemudaan',
                'description' => 'OKP',
            ],
            [
                'name' => 'Sekolah',
                'description' => 'OSIS atau Ekstrakurikuler',
            ],
            [
                'name' => 'Perguruan Tinggi',
                'description' => 'UKM Kampus',
            ],
        ];

        foreach ($categories as $category) {
            OrganizationCategory::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}