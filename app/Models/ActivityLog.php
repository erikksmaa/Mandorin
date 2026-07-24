<?php

namespace App\Models;

use App\Enums\ActivityStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'created_by',
        'title',
        'description',
        'activity_date',
        'progress_percentage',
        'issues',
        'solutions',
        'status',
        'verifier_notes',
    ];

    protected function casts(): array
    {
        return [
            'activity_date'       => 'date',
            'progress_percentage' => 'integer',
            'status'              => ActivityStatus::class,
        ];
    }

    // ── Relationships ──────────────────────────────────────────────

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ActivityPhoto::class, 'activity_log_id');
    }
}