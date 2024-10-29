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
                AbilityiesEnum::CREATE_PLAYLIST->value,
                AbilityiesEnum::ADD_MUSIC_TO_PLAYLIST->value,
                AbilityiesEnum::FOLLOW->value,
                AbilityiesEnum::LIKE->value,
                //TODO:DONE
            ],
            RoleEnum::ARTIST->value => [
                AbilityiesEnum::SHOW_MUSICS->value,
                AbilityiesEnum::ACCESS_TOKEN->value,
                AbilityiesEnum::CREATE_PLAYLIST->value,
                AbilityiesEnum::ADD_MUSIC_TO_PLAYLIST->value,
                AbilityiesEnum::FOLLOW->value,
                AbilityiesEnum::LIKE->value,
                AbilityiesEnum::CREATE_ALBUM->value,
                AbilityiesEnum::CREATE_SHOW->value,
                AbilityiesEnum::CREATE_PODCAST->value,
                AbilityiesEnum::CREATE_MUSIC->value,
            ],
            RoleEnum::ADMIN->value => ['*'],
            default => AbilityiesEnum::ACCESS_TOKEN->value //TODO implemnt throw ecxeption
        };
    }
}
