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
                'name'        => 'Karang Taruna',
                'description' => 'Organisasi kepemudaan tingkat desa/kelurahan yang berfokus pada pemberdayaan pemuda.',
            ],
            [
                'name'        => 'Komunitas Pemuda',
                'description' => 'Komunitas non-formal yang diinisiasi oleh pemuda untuk kegiatan positif.',
            ],
            [
                'name'        => 'Organisasi Mahasiswa',
                'description' => 'Organisasi kemahasiswaan dari perguruan tinggi di wilayah Pemalang.',
            ],
            [
                'name'        => 'Organisasi Kepemudaan',
                'description' => 'OKP yang memiliki legalitas formal dan bergerak di bidang kepemudaan.',
            ],
            [
                'name'        => 'Klub Olahraga',
                'description' => 'Klub olahraga aktif yang menaungi atlet muda di berbagai cabang olahraga.',
            ],
            [
                'name'        => 'Komunitas Sosial',
                'description' => 'Komunitas yang bergerak di bidang sosial, lingkungan, dan kemanusiaan.',
            ],
        ];

        foreach ($categories as $category) {
            OrganizationCategory::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}