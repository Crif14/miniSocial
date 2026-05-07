<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['postId', 'userId', 'body', 'isFlagged'];

    protected $casts = [
        'isFlagged' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'postId');
    }
}