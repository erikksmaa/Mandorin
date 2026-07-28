<?php

namespace Database\Seeders;

use App\Models\ProgramCategory;
use Illuminate\Database\Seeder;

class ProgramCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Pelatihan',              'description' => 'Program pelatihan keterampilan dan pengembangan SDM pemuda.'],
            ['name' => 'Seminar',                'description' => 'Kegiatan seminar, talkshow, dan diskusi publik kepemudaan.'],
            ['name' => 'Workshop',               'description' => 'Workshop praktis untuk peningkatan kompetensi pemuda.'],
            ['name' => 'Olahraga',               'description' => 'Program olahraga, turnamen, dan pembinaan atlet muda.'],
            ['name' => 'Kewirausahaan',          'description' => 'Program pemberdayaan wirausaha muda dan UMKM pemuda.'],
            ['name' => 'Pengabdian Masyarakat',  'description' => 'Kegiatan bakti sosial dan pengabdian kepada masyarakat.'],
            ['name' => 'Kompetisi',              'description' => 'Kompetisi dan lomba untuk pemuda di berbagai bidang.'],
            ['name' => 'Kegiatan Sosial',        'description' => 'Kegiatan sosial kemasyarakatan oleh dan untuk pemuda.'],
        ];

        foreach ($categories as $category) {
            ProgramCategory::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}