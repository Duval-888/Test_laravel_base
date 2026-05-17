<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModerationLog extends Model
{
    use HasFactory;

    protected $fillable = ['moderator_id', 'post_id', 'topic_id', 'action', 'reason'];

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
