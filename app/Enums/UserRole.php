<?php

namespace App\Enums;

enum UserRole: string
{
    case Customer = 'customer';
    case Contractor = 'contractor';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::Customer => 'Customer',
            self::Contractor => 'Contractor',
            self::Admin => 'Administrator',
        };
    }
}