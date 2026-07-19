<?php

namespace Database\Seeders;

use App\Enums\NotificationType;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $notifications = [

            [
                'email' => 'admin@mandorin.test',
                'type' => NotificationType::System,
                'title' => 'Selamat Datang',
                'message' => 'Dashboard administrator siap digunakan.',
            ],

            [
                'email' => 'budi@mandorin.test',
                'type' => NotificationType::Verification,
                'title' => 'Profil Diverifikasi',
                'message' => 'Profil mandor Anda telah berhasil diverifikasi.',
            ],

            [
                'email' => 'ahmad@mandorin.test',
                'type' => NotificationType::Project,
                'title' => 'Proyek Selesai',
                'message' => 'Proyek Renovasi Rumah Minimalis telah selesai.',
            ],

        ];

        foreach ($notifications as $item) {

            $user = User::where('email', $item['email'])->first();

            if (!$user) {
                continue;
            }

            Notification::updateOrCreate(

                [
                    'user_id' => $user->id,
                    'title' => $item['title'],
                ],

                [
                    'type' => $item['type'],
                    'message' => $item['message'],
                    'is_read' => false,
                ]

            );

        }
    }
}