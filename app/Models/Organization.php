<?php

namespace App\Models;

use App\Enums\OrganizationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'created_by',
        'organization_code',
        'name',
        'slug',
        'description',
        'logo',
        'address',
        'phone',
        'email',
        'website',
        'established_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'established_at' => 'date',
            'status'         => OrganizationStatus::class,
        ];
    }

    // ── Relationships ──────────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(OrganizationCategory::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members(): HasMany
    {
        return $this->hasMany(OrganizationMember::class, 'organization_id');
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class, 'organization_id');
    }
}