<?php

namespace App\Enums;

enum ProgramStatus: string
{
    case Draft = 'Draft';
    case Submitted = 'Submitted';
    case Approved = 'Approved';
    case Running = 'Running';
    case Completed = 'Completed';
    case Cancelled = 'Cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Submitted => 'Diajukan',
            self::Approved => 'Disetujui',
            self::Running => 'Berjalan',
            self::Completed => 'Selesai',
            self::Cancelled => 'Dibatalkan',
        };
    }
}