<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityAttachment extends Model
{
    protected $fillable = [
        'community_post_id',
        'file',
        'caption',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(
            CommunityPost::class,
            'community_post_id'
        );
    }
}