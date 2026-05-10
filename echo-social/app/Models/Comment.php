<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'postId',
        'userId',
        'body',
        'isFlagged',
        'flaggedAt',
        'reviewedAt',
        'reviewStatus',
    ];

    protected $casts = [
        'isFlagged' => 'boolean',
        'flaggedAt' => 'datetime',
        'reviewedAt' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'postId');
    }

    // Commento visibile se non flaggato o se approvato dall'admin
    public function isVisible(): bool
    {
        if (!$this->isFlagged) return true;
        return $this->reviewStatus === 'approved';
    }

    // Commento in attesa di revisione
    public function isPending(): bool
    {
        return $this->isFlagged && $this->reviewStatus === null;
    }
}