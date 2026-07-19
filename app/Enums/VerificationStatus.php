<?php

namespace App\Enums;

enum VerificationStatus: string
{
    case Pending = 'pending';
    case Verified = 'verified';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu Verifikasi',
            self::Verified => 'Terverifikasi',
            self::Rejected => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending  => 'bg-amber-100 text-amber-700',
            self::Verified => 'bg-green-100 text-green-700',
            self::Rejected => 'bg-red-100 text-red-700',
        };
    }
}