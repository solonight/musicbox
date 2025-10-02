<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'release_year', 'genre', 'cover_image', 'artist_id'];

    public function songs()
    {
        return $this->hasMany(\App\Models\Song::class);
    }

    public function artist()
    {
        return $this->belongsTo(\App\Models\Artist::class);
    }
}