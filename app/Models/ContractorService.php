<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractorService extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'contractor_profile_id',
        'service_id',
    ];

    public function contractorProfile(): BelongsTo
    {
        return $this->belongsTo(ContractorProfile::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}