<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $timestamps = false;
        protected $fillable = ['likes']; // <-- Aqui


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
