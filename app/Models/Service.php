<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    public function contractors(): BelongsToMany
    {
        return $this->belongsToMany(
            ContractorProfile::class,
            'contractor_services'
        );
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}