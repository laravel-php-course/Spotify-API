<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function musics()
    {
        return $this->hasMany(Music::class);
    }
    public function albums()
    {
        return $this->hasMany(Album::class);
    }
    public function followers()
    {
        return $this->hasMany(Follower::class);
    }
}
