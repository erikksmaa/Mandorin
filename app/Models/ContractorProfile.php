<?php

namespace App\Models;

use App\Enums\VerificationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractorProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'profile_photo',
        'bio',
        'address',
        'verification_status',
        'rating',
        'total_reviews',
        'total_projects',
        'identity_document',
        'certificate_document',
    ];

    protected function casts(): array
    {
        return [
            'verification_status' => VerificationStatus::class,
            'rating' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            Service::class,
            'contractor_services'
        );
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }
}