<?php

namespace App\Models;

// use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'gender',
        'birth_date',
        'address',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'birth_date' => 'date',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class, 'created_by');
    }

    public function ledPrograms(): HasMany
    {
        return $this->hasMany(Program::class, 'leader_id');
    }

    public function createdPrograms(): HasMany
    {
        return $this->hasMany(Program::class, 'created_by');
    }

    public function verifiedPrograms(): HasMany
    {
        return $this->hasMany(Program::class, 'verified_by');
    }

    public function organizationMemberships(): HasMany
    {
        return $this->hasMany(OrganizationMember::class);
    }

    public function programMemberships(): HasMany
    {
        return $this->hasMany(ProgramMember::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'created_by');
    }

    public function verifiedFinancialReports(): HasMany
    {
        return $this->hasMany(FinancialReport::class, 'verified_by');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}