<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function album(){
        return $this->belongsTo(Album::class);
    }
    public function music(){
        return $this->belongsTo(Music::class);
    }
}
