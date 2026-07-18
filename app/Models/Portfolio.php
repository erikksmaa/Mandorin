<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'mandor_profile_id',
        'judul',
        'foto_before',
        'foto_after',
        'deskripsi',
    ];

    public function mandorProfile(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MandorProfile::class);
    }
}
