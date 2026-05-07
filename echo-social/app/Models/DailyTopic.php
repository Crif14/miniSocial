<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DailyTopic extends Model
{
    protected $table = 'dailyTopics';

    protected $fillable = ['userId', 'title', 'description', 'topicDate'];

    protected $casts = [
        'topicDate' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('topicDate', Carbon::today());
    }
}