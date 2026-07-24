<?php

namespace App\Enums;

enum ProposalStatus: string
{
    case Pending = 'Pending';
    case Verified = 'Verified';
    case Revision = 'Revision';
    case Rejected = 'Rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu',
            self::Verified => 'Terverifikasi',
            self::Revision => 'Revisi',
            self::Rejected => 'Ditolak',
        };
    }
}