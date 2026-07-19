<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Pending = 'pending';
    case Accepted = 'accepted';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';

    public function color(): string
    {
        return match($this) {
            self::Pending => 'bg-amber-100 text-amber-700',
            self::Accepted => 'bg-blue-100 text-blue-700',
            self::InProgress => 'bg-indigo-100 text-indigo-700',
            self::Completed => 'bg-green-100 text-green-700',
            self::Rejected => 'bg-red-100 text-red-700',
            self::Cancelled => 'bg-slate-100 text-slate-700',
        };
    }

    public function label(): string
    {
        return match($this) {
            self::Pending => 'Menunggu',
            self::Accepted => 'Diterima',
            self::InProgress => 'Berjalan',
            self::Completed => 'Selesai',
            self::Rejected => 'Ditolak',
            self::Cancelled => 'Dibatalkan',
        };
    }
}