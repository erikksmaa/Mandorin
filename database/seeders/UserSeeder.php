<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roleMap = Role::pluck('id', 'slug');

        $users = [
            [
                'name' => 'Administrator SIPORA',
                'email' => 'admin@sipora.id',
                'role_slug' => 'administrator',
                'phone' => '081111111111',
                'gender' => 'L',
            ],
            [
                'name' => 'Verifikator Dindikpora',
                'email' => 'verifikator@sipora.id',
                'role_slug' => 'verifikator',
                'phone' => '082222222222',
                'gender' => 'P',
            ],
            [
                'name' => 'Ketua Pelaksana Program',
                'email' => 'leader@sipora.id',
                'role_slug' => 'leader',
                'phone' => '083333333333',
                'gender' => 'L',
            ],
            [
                'name' => 'Anggota Program',
                'email' => 'member@sipora.id',
                'role_slug' => 'member',
                'phone' => '084444444444',
                'gender' => 'P',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'role_id' => $roleMap[$user['role_slug']] ?? $roleMap['member'],
                    'name' => $user['name'],
                    'phone' => $user['phone'],
                    'password' => Hash::make('password'),
                    'gender' => $user['gender'],
                    'is_active' => true,
                ]
            );
        }
    }
}
