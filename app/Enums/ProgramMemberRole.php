<?php

namespace App\Enums;

enum ProgramMemberRole: string
{
    case Leader = 'Leader';
    case Secretary = 'Secretary';
    case Treasurer = 'Treasurer';
    case Member = 'Member';
    case Volunteer = 'Volunteer';

    public function label(): string
    {
        return match ($this) {
            self::Leader => 'Ketua Pelaksana',
            self::Secretary => 'Sekretaris',
            self::Treasurer => 'Bendahara',
            self::Member => 'Anggota',
            self::Volunteer => 'Relawan',
        };
    }

    public static function options(): array
    {
        return array_map(fn(self $role) => [
            'value' => $role->value,
            'label' => $role->label(),
        ], self::cases());
    }
}