<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case Present = 'present';
    case Absent = 'absent';
    case Leave = 'leave';

    public function label(): string
    {
        return match ($this) {
            self::Present => 'Hadir',
            self::Absent => 'Tidak Hadir',
            self::Leave => 'Izin',
        };
    }
}