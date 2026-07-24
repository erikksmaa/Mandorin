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
                'name' => 'Administrator',
                'slug' => 'administrator',
                'description' => 'Administrator sistem',
            ],
            [
                'name' => 'Verifikator',
                'slug' => 'verifikator',
                'description' => 'Petugas verifikasi program',
            ],
            [
                'name' => 'Ketua Pelaksana',
                'slug' => 'leader',
                'description' => 'Ketua pelaksana program',
            ],
            [
                'name' => 'Anggota',
                'slug' => 'member',
                'description' => 'Anggota program',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}