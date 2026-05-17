<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produit extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'nom',
        'qte',
        'prix',
        'description'
    ];

    public function userprod(){
        return $this->belongsTo(user::class);
    }
    public function users()
    {
        return $this->belongsToMany(user::class);
    }
    public function comments()
{
    return $this->morphMany(Comment::class, 'commentable');
}
}
