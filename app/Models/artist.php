<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'bio', 'genre', 'image_url'];

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}