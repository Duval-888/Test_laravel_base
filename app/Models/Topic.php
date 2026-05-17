<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content',
        'user_id', 'category_id',
        'views_count', 'is_pinned', 'is_locked',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function isLocked(): bool
    {
        return (bool) $this->is_locked;
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
