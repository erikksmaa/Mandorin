<?php

namespace App\Enums;

enum NotificationType: string
{
    case System = 'system';
    case Verification = 'verification';
    case Project = 'project';
    case Payment = 'payment';
    case Review = 'review';

    public function label(): string
    {
        return match ($this) {
            self::System => 'Sistem',
            self::Verification => 'Verifikasi',
            self::Project => 'Proyek',
            self::Payment => 'Pembayaran',
            self::Review => 'Ulasan',
        };
    }
}