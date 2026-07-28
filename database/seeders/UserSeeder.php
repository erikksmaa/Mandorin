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
        $roles = Role::pluck('id', 'slug');

        $users = [
            // Administrator
            [
                'role_slug'  => 'administrator',
                'name'       => 'Ahmad Fauzi',
                'email'      => 'ahmad.fauzi@sipora.id',
                'phone'      => '081234567890',
                'gender'     => 'L',
                'birth_date' => '1985-04-10',
                'address'    => 'Jl. Pemuda No. 1, Pemalang',
            ],

            // Verifikator (2 orang)
            [
                'role_slug'  => 'verifikator',
                'name'       => 'Siti Rahayu',
                'email'      => 'siti.rahayu@sipora.id',
                'phone'      => '081298765432',
                'gender'     => 'P',
                'birth_date' => '1988-07-22',
                'address'    => 'Jl. Diponegoro No. 15, Pemalang',
            ],
            [
                'role_slug'  => 'verifikator',
                'name'       => 'Budi Santoso',
                'email'      => 'budi.santoso@sipora.id',
                'phone'      => '081311223344',
                'gender'     => 'L',
                'birth_date' => '1982-11-05',
                'address'    => 'Jl. Gatot Subroto No. 8, Pemalang',
            ],

            // Leader (4 orang)
            [
                'role_slug'  => 'leader',
                'name'       => 'Rizki Maulana',
                'email'      => 'rizki.maulana@sipora.id',
                'phone'      => '082112345678',
                'gender'     => 'L',
                'birth_date' => '1998-03-15',
                'address'    => 'Jl. Merdeka No. 22, Pemalang',
            ],
            [
                'role_slug'  => 'leader',
                'name'       => 'Dewi Kartika',
                'email'      => 'dewi.kartika@sipora.id',
                'phone'      => '082298765432',
                'gender'     => 'P',
                'birth_date' => '1999-06-28',
                'address'    => 'Jl. Pahlawan No. 5, Comal',
            ],
            [
                'role_slug'  => 'leader',
                'name'       => 'Bagas Saputra',
                'email'      => 'bagas.saputra@sipora.id',
                'phone'      => '083322334455',
                'gender'     => 'L',
                'birth_date' => '1997-09-12',
                'address'    => 'Jl. Sudirman No. 33, Petarukan',
            ],
            [
                'role_slug'  => 'leader',
                'name'       => 'Aulia Rahma',
                'email'      => 'aulia.rahma@sipora.id',
                'phone'      => '083344556677',
                'gender'     => 'P',
                'birth_date' => '2000-01-20',
                'address'    => 'Jl. Imam Bonjol No. 10, Taman',
            ],

            // Member (8 orang)
            [
                'role_slug'  => 'member',
                'name'       => 'Nabila Putri',
                'email'      => 'nabila.putri@sipora.id',
                'phone'      => '085611112222',
                'gender'     => 'P',
                'birth_date' => '2001-08-17',
                'address'    => 'Jl. Kenanga No. 7, Pemalang',
            ],
            [
                'role_slug'  => 'member',
                'name'       => 'Dinda Ayu',
                'email'      => 'dinda.ayu@sipora.id',
                'phone'      => '085622223333',
                'gender'     => 'P',
                'birth_date' => '2002-05-14',
                'address'    => 'Jl. Melati No. 3, Pemalang',
            ],
            [
                'role_slug'  => 'member',
                'name'       => 'Fajar Nugroho',
                'email'      => 'fajar.nugroho@sipora.id',
                'phone'      => '085633334444',
                'gender'     => 'L',
                'birth_date' => '1999-12-03',
                'address'    => 'Jl. Anggrek No. 11, Comal',
            ],
            [
                'role_slug'  => 'member',
                'name'       => 'Hendra Wijaya',
                'email'      => 'hendra.wijaya@sipora.id',
                'phone'      => '085644445555',
                'gender'     => 'L',
                'birth_date' => '2000-04-25',
                'address'    => 'Jl. Mawar No. 9, Petarukan',
            ],
            [
                'role_slug'  => 'member',
                'name'       => 'Intan Permata',
                'email'      => 'intan.permata@sipora.id',
                'phone'      => '085655556666',
                'gender'     => 'P',
                'birth_date' => '2001-10-08',
                'address'    => 'Jl. Dahlia No. 6, Taman',
            ],
            [
                'role_slug'  => 'member',
                'name'       => 'Yoga Pratama',
                'email'      => 'yoga.pratama@sipora.id',
                'phone'      => '085666667777',
                'gender'     => 'L',
                'birth_date' => '1998-07-30',
                'address'    => 'Jl. Flamboyan No. 14, Pemalang',
            ],
            [
                'role_slug'  => 'member',
                'name'       => 'Reni Safitri',
                'email'      => 'reni.safitri@sipora.id',
                'phone'      => '085677778888',
                'gender'     => 'P',
                'birth_date' => '2002-02-19',
                'address'    => 'Jl. Seroja No. 2, Comal',
            ],
            [
                'role_slug'  => 'member',
                'name'       => 'Aldi Firmansyah',
                'email'      => 'aldi.firmansyah@sipora.id',
                'phone'      => '085688889999',
                'gender'     => 'L',
                'birth_date' => '2000-09-05',
                'address'    => 'Jl. Cempaka No. 18, Petarukan',
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'role_id'    => $roles[$data['role_slug']],
                    'name'       => $data['name'],
                    'phone'      => $data['phone'],
                    'password'   => Hash::make('password'),
                    'gender'     => $data['gender'],
                    'birth_date' => $data['birth_date'],
                    'address'    => $data['address'],
                    'is_active'  => true,
                ]
            );
        }
    }
}