<?php

namespace App\Models;

use App\Enums\PhotoType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_log_id',
        'photo',
        'caption',
        'photo_type',
    ];

    protected function casts(): array
    {
        return [
            'photo_type' => PhotoType::class,
        ];
    }

    // ── Relationships ──────────────────────────────────────────────

    public function activityLog(): BelongsTo
    {
        return $this->belongsTo(ActivityLog::class, 'activity_log_id');
    }
}