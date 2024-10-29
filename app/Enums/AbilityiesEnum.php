<?php

namespace App\Enums;

enum AbilityiesEnum :string {
    case ACCESS_TOKEN = 'access-token';
    case REFRESH_TOKEN = 'refresh-token';
    case SHOW_MUSICS = 'show-musics';
    case CREATE_PLAYLIST = 'create-playlist';
    case ADD_MUSIC_TO_PLAYLIST = 'add-music-to-playlist';
    case FOLLOW = 'follow';
    case LIKE = 'like';
    case CREATE_ALBUM = 'create-album';
    case CREATE_SHOW = 'create-show';
    case CREATE_PODCAST = 'create-podcast';
    case CREATE_MUSIC = 'create-music';
}
