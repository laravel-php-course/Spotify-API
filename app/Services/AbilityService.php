<?php

namespace App\Services;
use App\Enums\AbilityiesEnum;
use App\Enums\RoleEnum;

class AbilityService
{
    public static function getAbiliteis(string $role = 'user')
    {
        return match ($role) {
            RoleEnum::USER->value => [
                AbilityiesEnum::SHOW_MUSICS->value,
                AbilityiesEnum::ACCESS_TOKEN->value,
                //TODO
            ],
            RoleEnum::SINGER->value => [
                //TODO
            ],
            default => AbilityiesEnum::ACCESS_TOKEN->value //TODO implemnt throw ecxeption
        };
    }
}
