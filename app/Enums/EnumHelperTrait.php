<?php

namespace App\Enums;

trait EnumHelperTrait
{

    public static function getArray()
    {
        return array_column(self::cases(), 'name');
    }
}
