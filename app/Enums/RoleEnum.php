<?php

namespace App\Enums;

enum RoleEnum: string
{
    case USER = 'user';
    case ARTIST = 'artist';
    case ADMIN = 'admin';

}
