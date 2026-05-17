<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
     protected $fillable = [
        'titre',
        'url',
        'description',
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}