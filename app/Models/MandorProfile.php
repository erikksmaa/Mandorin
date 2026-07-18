<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MandorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'keahlian',
        'kategori',
        'lokasi_teks',
        'rating',
        'jumlah_proyek_selesai',
        'status_verifikasi',
        'dokumen_ktp',
        'dokumen_sertifikat',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function portfolios(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Portfolio::class);
    }

    public function proyek(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Proyek::class, 'mandor_id', 'user_id');
    }
}
