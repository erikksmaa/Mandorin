<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name'        => 'Administrator',
                'slug'        => 'administrator',
                'description' => 'Administrator sistem SIPORA, memiliki akses penuh ke seluruh fitur.',
            ],
            [
                'name'        => 'Verifikator',
                'slug'        => 'verifikator',
                'description' => 'Petugas Dindikpora yang bertugas memverifikasi proposal dan laporan program.',
            ],
            [
                'name'        => 'Ketua Pelaksana',
                'slug'        => 'leader',
                'description' => 'Ketua pelaksana program dari organisasi pemuda.',
            ],
            [
                'name'        => 'Anggota',
                'slug'        => 'member',
                'description' => 'Anggota program kepemudaan dan olahraga.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}