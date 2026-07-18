<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function mandorProfile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MandorProfile::class);
    }

    public function proyekSebagaiPelanggan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Proyek::class, 'pelanggan_id');
    }

    public function proyekSebagaiMandor(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Proyek::class, 'mandor_id');
    }
}
