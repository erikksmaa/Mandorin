<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationMember extends Model
{
    protected $fillable = [
        'organization_id',
        'user_id',
        'position',
        'joined_at',
        'left_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'position'  => \App\Enums\OrganizationPosition::class,
            'joined_at' => 'date',
            'left_at'   => 'date',
            'status'    => \App\Enums\MemberStatus::class,
        ];
    }

    public function organization(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
