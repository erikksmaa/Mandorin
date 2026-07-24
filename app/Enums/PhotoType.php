<?php

namespace App\Enums;

enum PhotoType: string
{
    case Before = 'Before';
    case Progress = 'Progress';
    case After = 'After';
    case Documentation = 'Documentation';

    public function label(): string
    {
        return match ($this) {
            self::Before => 'Sebelum',
            self::Progress => 'Proses',
            self::After => 'Sesudah',
            self::Documentation => 'Dokumentasi',
        };
    }

    public static function options(): array
    {
        return array_map(fn(self $type) => [
            'value' => $type->value,
            'label' => $type->label(),
        ], self::cases());
    }
}