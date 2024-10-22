<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'user'=> new UserResource($this->user),
            'album'=> new AlbumResource($this->album),
            'music'=> new musicResource($this->music),
        ];
    }
}
