<?php

namespace App\Models;

use App\Enums\CommunityReportReason;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityReport extends Model
{
    protected $fillable = [
        'community_post_id',
        'user_id',
        'reason',
        'description',
    ];

    protected $casts = [
        'reason' => CommunityReportReason::class,
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(
            CommunityPost::class,
            'community_post_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}