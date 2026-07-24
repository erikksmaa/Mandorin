<?php

namespace Database\Seeders;

use App\Models\ProgramCategory;
use Illuminate\Database\Seeder;

class ProgramCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kepemudaan',
                'description' => 'Program Kepemudaan',
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Program Olahraga',
            ],
            [
                'name' => 'Pelatihan',
                'description' => 'Pelatihan SDM',
            ],
            [
                'name' => 'Kewirausahaan',
                'description' => 'Program UMKM',
            ],
            [
                'name' => 'Sosial',
                'description' => 'Program Sosial',
            ],
            [
                'name' => 'Lingkungan',
                'description' => 'Program Lingkungan',
            ],
        ];

        foreach ($categories as $category) {
            ProgramCategory::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}