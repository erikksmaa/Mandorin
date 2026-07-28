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
        $admin    = User::where('email', 'ahmad.fauzi@sipora.id')->first();
        $catMap   = OrganizationCategory::pluck('id', 'name');

        $organizations = [
            [
                'organization_code' => 'ORG-001',
                'name'              => 'Karang Taruna Maju Bersama',
                'slug'              => 'karang-taruna-maju-bersama',
                'category'          => 'Karang Taruna',
                'description'       => 'Organisasi kepemudaan Desa Maju Bersama yang aktif dalam kegiatan sosial, olahraga, dan pemberdayaan pemuda.',
                'address'           => 'Jl. Desa Maju No. 1, Kec. Pemalang, Kab. Pemalang',
                'phone'             => '081311000001',
                'email'             => 'kt.majubersama@gmail.com',
                'website'           => 'https://kt-majubersama.id',
                'established_at'    => '2015-03-10',
                'status'            => OrganizationStatus::Active,
            ],
            [
                'organization_code' => 'ORG-002',
                'name'              => 'Pemuda Berkarya Pemalang',
                'slug'              => 'pemuda-berkarya-pemalang',
                'category'          => 'Komunitas Pemuda',
                'description'       => 'Komunitas pemuda Pemalang yang bergerak di bidang kreativitas, seni, dan kewirausahaan muda.',
                'address'           => 'Jl. Pahlawan No. 17, Pemalang',
                'phone'             => '081311000002',
                'email'             => 'pemudaberkarya@gmail.com',
                'website'           => 'https://pemudaberkarya.id',
                'established_at'    => '2018-06-01',
                'status'            => OrganizationStatus::Active,
            ],
            [
                'organization_code' => 'ORG-003',
                'name'              => 'Komunitas Digital Pemalang',
                'slug'              => 'komunitas-digital-pemalang',
                'category'          => 'Komunitas Pemuda',
                'description'       => 'Komunitas yang berfokus pada pengembangan literasi digital dan teknologi bagi pemuda Pemalang.',
                'address'           => 'Jl. Ahmad Yani No. 45, Pemalang',
                'phone'             => '081311000003',
                'email'             => 'digitalpemalang@gmail.com',
                'website'           => 'https://digitalpemalang.id',
                'established_at'    => '2020-01-15',
                'status'            => OrganizationStatus::Active,
            ],
            [
                'organization_code' => 'ORG-004',
                'name'              => 'Forum Generasi Kreatif',
                'slug'              => 'forum-generasi-kreatif',
                'category'          => 'Organisasi Kepemudaan',
                'description'       => 'Forum pemuda kreatif yang mendorong inovasi dan kreativitas generasi muda Pemalang.',
                'address'           => 'Jl. Sudirman No. 12, Pemalang',
                'phone'             => '081311000004',
                'email'             => 'forumgenkrea@gmail.com',
                'website'           => 'https://forumgenkrea.id',
                'established_at'    => '2019-08-17',
                'status'            => OrganizationStatus::Active,
            ],
            [
                'organization_code' => 'ORG-005',
                'name'              => 'Taruna Mandiri Comal',
                'slug'              => 'taruna-mandiri-comal',
                'category'          => 'Karang Taruna',
                'description'       => 'Karang Taruna aktif di wilayah Comal yang fokus pada kemandirian ekonomi pemuda.',
                'address'           => 'Jl. Raya Comal No. 8, Comal, Pemalang',
                'phone'             => '081311000005',
                'email'             => 'tarunamandiri.comal@gmail.com',
                'website'           => 'https://tarunamandiri-comal.id',
                'established_at'    => '2016-02-20',
                'status'            => OrganizationStatus::Active,
            ],
            [
                'organization_code' => 'ORG-006',
                'name'              => 'Pemuda Inspiratif Petarukan',
                'slug'              => 'pemuda-inspiratif-petarukan',
                'category'          => 'Komunitas Pemuda',
                'description'       => 'Komunitas pemuda di Kecamatan Petarukan yang berfokus pada inspirasi dan motivasi generasi muda.',
                'address'           => 'Jl. Raya Petarukan No. 20, Petarukan, Pemalang',
                'phone'             => '081311000006',
                'email'             => 'pemudainspira@gmail.com',
                'website'           => 'https://pemudainspira.id',
                'established_at'    => '2017-05-10',
                'status'            => OrganizationStatus::Active,
            ],
            [
                'organization_code' => 'ORG-007',
                'name'              => 'Klub Futsal Garuda Pemalang',
                'slug'              => 'klub-futsal-garuda-pemalang',
                'category'          => 'Klub Olahraga',
                'description'       => 'Klub futsal aktif yang membina atlet muda berbakat dari wilayah Kabupaten Pemalang.',
                'address'           => 'GOR Pemalang, Jl. Olahraga No. 1, Pemalang',
                'phone'             => '081311000007',
                'email'             => 'garudafutsal@gmail.com',
                'website'           => 'https://garudafutsal-pemalang.id',
                'established_at'    => '2014-09-05',
                'status'            => OrganizationStatus::Active,
            ],
            [
                'organization_code' => 'ORG-008',
                'name'              => 'Relawan Muda Pemalang',
                'slug'              => 'relawan-muda-pemalang',
                'category'          => 'Komunitas Sosial',
                'description'       => 'Komunitas relawan muda yang bergerak di bidang sosial, kemanusiaan, dan lingkungan hidup.',
                'address'           => 'Jl. Kartini No. 30, Pemalang',
                'phone'             => '081311000008',
                'email'             => 'relawanmuda@gmail.com',
                'website'           => 'https://relawanmuda-pemalang.id',
                'established_at'    => '2021-03-21',
                'status'            => OrganizationStatus::Active,
            ],
            [
                'organization_code' => 'ORG-009',
                'name'              => 'BEM STIE Pemalang',
                'slug'              => 'bem-stie-pemalang',
                'category'          => 'Organisasi Mahasiswa',
                'description'       => 'Badan Eksekutif Mahasiswa STIE Pemalang yang aktif menyelenggarakan program pelatihan dan pengabdian masyarakat.',
                'address'           => 'Kampus STIE Pemalang, Jl. Dr. Cipto No. 5, Pemalang',
                'phone'             => '081311000009',
                'email'             => 'bem.stiepemalang@gmail.com',
                'website'           => 'https://bem-stiepemalang.ac.id',
                'established_at'    => '2012-07-01',
                'status'            => OrganizationStatus::Active,
            ],
            [
                'organization_code' => 'ORG-010',
                'name'              => 'HIPMI Pemalang',
                'slug'              => 'hipmi-pemalang',
                'category'          => 'Organisasi Kepemudaan',
                'description'       => 'Himpunan Pengusaha Muda Indonesia Pemalang, mendorong tumbuhnya wirausahawan muda di Kabupaten Pemalang.',
                'address'           => 'Jl. Pemuda No. 55, Pemalang',
                'phone'             => '081311000010',
                'email'             => 'hipmi.pemalang@gmail.com',
                'website'           => 'https://hipmi-pemalang.id',
                'established_at'    => '2013-11-28',
                'status'            => OrganizationStatus::Active,
            ],
        ];

        foreach ($organizations as $org) {
            Organization::updateOrCreate(
                ['organization_code' => $org['organization_code']],
                [
                    'category_id'       => $catMap[$org['category']],
                    'created_by'        => $admin->id,
                    'organization_code' => $org['organization_code'],
                    'name'              => $org['name'],
                    'slug'              => $org['slug'],
                    'description'       => $org['description'],
                    'logo'              => 'logos/placeholder.png',
                    'address'           => $org['address'],
                    'phone'             => $org['phone'],
                    'email'             => $org['email'],
                    'website'           => $org['website'],
                    'established_at'    => $org['established_at'],
                    'status'            => $org['status'],
                ]
            );
        }
    }
}