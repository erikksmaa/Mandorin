<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'tim_kuli_id',
        'proyek_id',
        'tanggal',
        'hadir',
    ];

    public function timKuli(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TimKuli::class);
    }

    public function proyek(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Proyek::class);
    }
}
