<?php

namespace App\Models;

use App\Enums\ProposalStatus;
use App\Enums\ProgramStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organization_id',
        'leader_id',
        'category_id',
        'created_by',
        'verified_by',
        'program_code',
        'title',
        'slug',
        'description',
        'objective',
        'target',
        'location',
        'budget',
        'proposal_file',
        'proposal_status',
        'proposal_notes',
        'status',
        'start_date',
        'end_date',
        'verified_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'budget'          => 'decimal:2',
            'start_date'      => 'date',
            'end_date'        => 'date',
            'verified_at'     => 'datetime',
            'completed_at'    => 'datetime',
            'proposal_status' => ProposalStatus::class,
            'status'          => ProgramStatus::class,
        ];
    }

    // ── Relationships ──────────────────────────────────────────────

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProgramCategory::class, 'category_id');
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function members(): HasMany
    {
        return $this->hasMany(ProgramMember::class, 'program_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'program_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'program_id');
    }

    public function financialReport(): HasOne
    {
        return $this->hasOne(FinancialReport::class, 'program_id');
    }

    public function getProgressAttribute(): int
    {
        $statusVal = $this->status instanceof \BackedEnum ? $this->status->value : $this->status;
        $propVal = $this->proposal_status instanceof \BackedEnum ? $this->proposal_status->value : $this->proposal_status;

        $latestLog = $this->activityLogs()
            ->orderBy('activity_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $latestLogProgress = $latestLog ? (int) $latestLog->progress_percentage : 0;
        
        $lpjStatus = $this->financialReport ? ($this->financialReport->status instanceof \BackedEnum ? $this->financialReport->status->value : $this->financialReport->status) : null;

        $isPropVerified = in_array($propVal, ['Verified', 'Approved']);
        $isProgramCompleted = ($statusVal === 'Completed');
        $isLogbookMin90 = ($latestLogProgress >= 90);
        $isLpjApproved = ($lpjStatus === 'Approved');

        // 100% ONLY IF ALL 4 CONDITIONS ARE MET:
        if ($isPropVerified && $isProgramCompleted && $isLogbookMin90 && $isLpjApproved) {
            return 100;
        }

        // E-LPJ Submitted or Approved: 95%
        if ($lpjStatus === 'Submitted' || $lpjStatus === 'Approved') {
            return 95;
        }

        // Progress following latest Logbook (if logbook exists)
        if ($latestLogProgress > 0) {
            return min(94, max(30, $latestLogProgress));
        }

        // Program Running milestone: 30%
        if ($statusVal === 'Running') {
            return 30;
        }

        // Proposal Verified milestone: 20%
        if ($isPropVerified) {
            return 20;
        }

        // Proposal Submitted milestone: 10%
        if (in_array($propVal, ['Pending', 'Submitted'])) {
            return 10;
        }

        // Draft Program: 0%
        return 0;
    }
}