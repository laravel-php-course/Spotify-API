<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function show()
    {
        return $this->belongsTo(Show::class);
    }
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
