<?php

namespace App\Models;

use App\Enums\FinancialStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'verified_by',
        'report_number',
        'total_budget',
        'total_income',
        'total_expense',
        'remaining_budget',
        'status',
        'submitted_at',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'total_budget'     => 'decimal:2',
            'total_income'     => 'decimal:2',
            'total_expense'    => 'decimal:2',
            'remaining_budget' => 'decimal:2',
            'status'           => FinancialStatus::class,
            'submitted_at'     => 'datetime',
            'verified_at'      => 'datetime',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(FinancialItem::class, 'financial_report_id');
    }
}