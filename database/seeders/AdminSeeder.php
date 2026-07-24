<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'administrator')->first();

        if (! $adminRole) {
            return;
        }

        User::updateOrCreate(
            ['email' => 'admin@sipora.id'],
            [
                'role_id' => $adminRole->id,
                'name' => 'Administrator SIPORA',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'gender' => 'L',
                'is_active' => true,
            ]
        );
    }
}