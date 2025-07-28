<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'title',
        'content', // adicione outros campos conforme necessário
    ];

    // Relacionamento com Tags (muitos para muitos)
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Relacionamento com Likes (um para muitos)
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Relacionamento com Dislikes (um para muitos)
    public function dislikes()
    {
        return $this->hasMany(Dislike::class);
    }

    // Relacionamento com Comentários (um para muitos)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

}
