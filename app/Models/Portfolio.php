<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contractor_profile_id',
        'project_id',
        'title',
        'description',
        'before_photo',
        'after_photo',
    ];

    public function contractorProfile(): BelongsTo
    {
        return $this->belongsTo(ContractorProfile::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}