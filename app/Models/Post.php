<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'topic_id', 'user_id', 'parent_post_id',
        'content', 'votes_count', 'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function parent()
    {
        return $this->belongsTo(Post::class, 'parent_post_id');
    }

    public function replies()
    {
        return $this->hasMany(Post::class, 'parent_post_id');
    }

    public function averageRating(): float
    {
        return round($this->votes()->whereNotNull('value')->avg('value') ?? 0, 1);
    }

    public function ratingsCount(): int
    {
        return $this->votes()->whereNotNull('value')->count();
    }

    public function stars(): string
    {
        $average = (int) round($this->votes()->whereNotNull('value')->avg('value') ?? 0);
        return str_repeat('★', $average) . str_repeat('☆', 5 - $average);
    }
}
