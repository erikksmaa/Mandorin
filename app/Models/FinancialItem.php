<?php

namespace App\Models;

use App\Enums\FinancialType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'financial_report_id',
        'type',
        'category',
        'description',
        'quantity',
        'unit_price',
        'subtotal',
        'receipt',
        'transaction_date',
    ];

    protected function casts(): array
    {
        return [
            'type'             => FinancialType::class,
            'quantity'         => 'integer',
            'unit_price'       => 'decimal:2',
            'subtotal'         => 'decimal:2',
            'transaction_date' => 'date',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────

    public function report(): BelongsTo
    {
        return $this->belongsTo(FinancialReport::class, 'financial_report_id');
    }
}