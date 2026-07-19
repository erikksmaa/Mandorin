<?php

namespace Database\Seeders;

use App\Enums\VerificationStatus;
use App\Models\ContractorProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContractorProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [

            [
                'email' => 'budi@mandorin.test',
                'bio' => 'Mandor berpengalaman dalam renovasi rumah dan pembangunan hunian minimalis.',
                'address' => 'Jl. Ahmad Yani No. 12, Pekalongan',
                'rating' => 4.9,
                'total_reviews' => 25,
                'total_projects' => 48,
            ],

            [
                'email' => 'andi@mandorin.test',
                'bio' => 'Spesialis instalasi listrik, air, dan pekerjaan plafon.',
                'address' => 'Jl. Diponegoro No. 45, Pemalang',
                'rating' => 4.8,
                'total_reviews' => 18,
                'total_projects' => 35,
            ],

            [
                'email' => 'rudi@mandorin.test',
                'bio' => 'Berpengalaman dalam interior, furniture custom, dan kanopi.',
                'address' => 'Jl. Gajah Mada No. 7, Tegal',
                'rating' => 4.7,
                'total_reviews' => 14,
                'total_projects' => 29,
            ],

        ];

        foreach ($profiles as $profile) {

            $user = User::where('email', $profile['email'])->first();

            ContractorProfile::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'user_id' => $user->id,
                    'bio' => $profile['bio'],
                    'address' => $profile['address'],
                    'verification_status' => VerificationStatus::Verified,
                    'rating' => $profile['rating'],
                    'total_reviews' => $profile['total_reviews'],
                    'total_projects' => $profile['total_projects'],
                    'profile_photo' => null,
                    'identity_document' => null,
                    'certificate_document' => null,
                ]
            );
        }
    }
}