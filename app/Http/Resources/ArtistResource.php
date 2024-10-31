<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name ,
            'biography' => musicResource::collection($this->bio),
            'profile_pic' => musicResource::collection($this->profile_pic),
            'musics' => musicResource::collection($this->whenLoaded('musics')),
            'albums' => AlbumResource::collection($this->whenLoaded('albums')),
            'Followers' => $this->followers()->count() ,
        ];
    }
}
