<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $table = 'proyek';

    protected $fillable = [
        'pelanggan_id',
        'mandor_id',
        'judul',
        'deskripsi',
        'lokasi',
        'tanggal_mulai',
        'status',
        'progres_persen',
    ];

    public function pelanggan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function mandor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'mandor_id');
    }

    public function timKuli(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TimKuli::class);
    }

    public function dprEntries(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DprEntry::class);
    }

    public function pembayaranLog(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PembayaranLog::class);
    }
}
