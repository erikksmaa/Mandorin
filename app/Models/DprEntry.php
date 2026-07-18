<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DprEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyek_id',
        'tanggal',
        'catatan',
        'progres_persen',
        'foto_sebelum',
        'foto_sesudah',
    ];

    public function proyek(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Proyek::class);
    }
}
