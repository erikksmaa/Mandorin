<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [

            // ==========================
            // ADMIN
            // ==========================

            [
                'name' => 'Administrator',
                'email' => 'admin@mandorin.test',
                'phone' => '081111111111',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
            ],

            // ==========================
            // CONTRACTOR
            // ==========================

            [
                'name' => 'Budi Santoso',
                'email' => 'budi@mandorin.test',
                'phone' => '081111111112',
                'password' => Hash::make('password'),
                'role' => UserRole::Contractor,
            ],

            [
                'name' => 'Andi Wijaya',
                'email' => 'andi@mandorin.test',
                'phone' => '081111111113',
                'password' => Hash::make('password'),
                'role' => UserRole::Contractor,
            ],

            [
                'name' => 'Rudi Hartono',
                'email' => 'rudi@mandorin.test',
                'phone' => '081111111114',
                'password' => Hash::make('password'),
                'role' => UserRole::Contractor,
            ],

            // ==========================
            // CUSTOMER
            // ==========================

            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@mandorin.test',
                'phone' => '081111111115',
                'password' => Hash::make('password'),
                'role' => UserRole::Customer,
            ],

            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@mandorin.test',
                'phone' => '081111111116',
                'password' => Hash::make('password'),
                'role' => UserRole::Customer,
            ],

            [
                'name' => 'Dimas Pratama',
                'email' => 'dimas@mandorin.test',
                'phone' => '081111111117',
                'password' => Hash::make('password'),
                'role' => UserRole::Customer,
            ],

            [
                'name' => 'Nabila Putri',
                'email' => 'nabila@mandorin.test',
                'phone' => '081111111118',
                'password' => Hash::make('password'),
                'role' => UserRole::Customer,
            ],

            [
                'name' => 'Rizky Saputra',
                'email' => 'rizky@mandorin.test',
                'phone' => '081111111119',
                'password' => Hash::make('password'),
                'role' => UserRole::Customer,
            ],

        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                [
                    'email' => $user['email'],
                ],
                $user
            );
        }
    }
}