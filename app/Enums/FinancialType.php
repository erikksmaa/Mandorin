<?php

namespace App\Enums;

enum FinancialType: string
{
    case Income = 'Income';
    case Expense = 'Expense';

    public function label(): string
    {
        return match ($this) {
            self::Income => 'Pemasukan',
            self::Expense => 'Pengeluaran',
        };
    }
}