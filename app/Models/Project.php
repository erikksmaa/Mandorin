<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_code',
        'customer_id',
        'contractor_id',
        'service_id',
        'title',
        'description',
        'address',
        'requested_at',
        'start_date',
        'estimated_finish_date',
        'completed_at',
        'progress_percentage',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'requested_at' => 'datetime',
            'start_date' => 'date',
            'estimated_finish_date' => 'date',
            'completed_at' => 'datetime',
            'status' => ProjectStatus::class,
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function contractor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function workers(): HasMany
    {
        return $this->hasMany(ProjectWorker::class);
    }

    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class);
    }

    public function paymentLogs(): HasMany
    {
        return $this->hasMany(PaymentLog::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ProjectStatusHistory::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}