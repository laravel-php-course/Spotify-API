<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
