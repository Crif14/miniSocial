<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = ['userId', 'body', 'isFlagged', 'flaggedReason'];

    protected $casts = [
        'isFlagged' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'postId')->latest();
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'postLikes', 'postId', 'userId');
    }

    public function embedding()
    {
        return $this->hasOne(Embedding::class, 'postId');
    }

    public function isLikedBy($user)
    {
        return $this->likes()->where('userId', $user->id)->exists();
    }
}