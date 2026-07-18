<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranLog extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_log';

    protected $fillable = [
        'proyek_id',
        'termin_ke',
        'nominal',
        'tanggal',
        'bukti_kuitansi',
        'dikonfirmasi_pelanggan',
    ];

    public function proyek(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Proyek::class);
    }
}
