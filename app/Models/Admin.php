<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable, hasFactory;

    protected $fillable = [
        'last_name',
        'first_name',
         'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
