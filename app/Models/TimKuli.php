<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimKuli extends Model
{
    use HasFactory;

    protected $table = 'tim_kuli';

    protected $fillable = [
        'proyek_id',
        'nama',
        'peran',
    ];

    public function proyek(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Proyek::class);
    }

    public function absensi(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
