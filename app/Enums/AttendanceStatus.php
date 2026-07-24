<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case Present = 'Present';
    case Absent = 'Absent';
    case Permission = 'Permission';

    public function label(): string
    {
        return match ($this) {
            self::Present => 'Hadir',
            self::Absent => 'Tidak Hadir',
            self::Permission => 'Izin',
        };
    }
}