<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Renovasi Rumah',
                'description' => 'Layanan renovasi rumah secara menyeluruh.',
                'icon' => 'home',
            ],
            [
                'name' => 'Bangun Rumah',
                'description' => 'Pembangunan rumah dari nol hingga selesai.',
                'icon' => 'building',
            ],
            [
                'name' => 'Pengecatan',
                'description' => 'Pengecatan interior maupun eksterior.',
                'icon' => 'paint-brush',
            ],
            [
                'name' => 'Pemasangan Keramik',
                'description' => 'Pemasangan keramik lantai dan dinding.',
                'icon' => 'grid',
            ],
            [
                'name' => 'Plafon',
                'description' => 'Pemasangan dan perbaikan plafon.',
                'icon' => 'square',
            ],
            [
                'name' => 'Pembuatan Atap',
                'description' => 'Pembuatan dan perbaikan atap rumah.',
                'icon' => 'roof',
            ],
            [
                'name' => 'Kanopi',
                'description' => 'Pembuatan kanopi baja ringan maupun besi.',
                'icon' => 'warehouse',
            ],
            [
                'name' => 'Pagar',
                'description' => 'Pembuatan pagar besi maupun beton.',
                'icon' => 'shield',
            ],
            [
                'name' => 'Instalasi Listrik',
                'description' => 'Pemasangan instalasi listrik rumah.',
                'icon' => 'bolt',
            ],
            [
                'name' => 'Instalasi Air',
                'description' => 'Pemasangan instalasi air bersih dan sanitasi.',
                'icon' => 'droplet',
            ],
            [
                'name' => 'Interior',
                'description' => 'Pengerjaan desain dan interior rumah.',
                'icon' => 'sofa',
            ],
            [
                'name' => 'Furniture Custom',
                'description' => 'Pembuatan furniture sesuai kebutuhan.',
                'icon' => 'hammer',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name']],
                $service
            );
        }
    }
}