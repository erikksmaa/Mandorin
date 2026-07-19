<?php

namespace Database\Seeders;

use App\Models\ContractorProfile;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ContractorServiceSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            'budi@mandorin.test' => [
                'Renovasi Rumah',
                'Bangun Rumah',
                'Pengecatan',
                'Pemasangan Keramik',
            ],

            'andi@mandorin.test' => [
                'Instalasi Listrik',
                'Instalasi Air',
                'Plafon',
            ],

            'rudi@mandorin.test' => [
                'Interior',
                'Furniture Custom',
                'Kanopi',
                'Pagar',
            ],

        ];

        foreach ($data as $email => $services) {

            $contractor = ContractorProfile::whereHas('user', function ($query) use ($email) {
                $query->where('email', $email);
            })->first();

            if (!$contractor) {
                continue;
            }

            $serviceIds = Service::whereIn('name', $services)
                ->pluck('id')
                ->toArray();

            $contractor->services()->sync($serviceIds);
        }
    }
}