<?php

namespace Database\Seeders;

use App\Models\ContractorProfile;
use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $portfolios = [

            'budi@mandorin.test' => [

                [
                    'title' => 'Renovasi Rumah Minimalis',
                    'description' => 'Renovasi rumah tipe 45 menjadi konsep minimalis modern.',
                ],

                [
                    'title' => 'Pembangunan Rumah 2 Lantai',
                    'description' => 'Pembangunan rumah tinggal dua lantai dengan desain modern.',
                ],

            ],

            'andi@mandorin.test' => [

                [
                    'title' => 'Instalasi Listrik Rumah',
                    'description' => 'Pemasangan instalasi listrik untuk rumah baru.',
                ],

                [
                    'title' => 'Pemasangan Plafon PVC',
                    'description' => 'Pemasangan plafon PVC pada ruang tamu dan ruang keluarga.',
                ],

            ],

            'rudi@mandorin.test' => [

                [
                    'title' => 'Interior Ruang Tamu',
                    'description' => 'Pembuatan interior bergaya Scandinavian.',
                ],

                [
                    'title' => 'Kanopi Baja Ringan',
                    'description' => 'Pemasangan kanopi baja ringan pada garasi rumah.',
                ],

            ],

        ];

        foreach ($portfolios as $email => $items) {

            $contractor = ContractorProfile::whereHas('user', function ($query) use ($email) {
                $query->where('email', $email);
            })->first();

            if (!$contractor) {
                continue;
            }

            foreach ($items as $item) {

                Portfolio::updateOrCreate(

                    [
                        'contractor_profile_id' => $contractor->id,
                        'title' => $item['title'],
                    ],

                    [
                        'description' => $item['description'],
                        'before_photo' => null,
                        'after_photo' => null,
                    ]

                );

            }

        }
    }
}