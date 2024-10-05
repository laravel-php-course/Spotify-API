<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class musicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title ,
            'album' => new albumResource($this->album)  ,
            'artist' => new artistResource($this->artist)  ,
            'category' => new categoryResource($this->category)  ,
            'cover' => $this->cover ,
            'file' => $this->file ,
            'producer' => $this->producer ,
            'lyric' => $this->lyric ,
            'About' => $this->About ,
        ];
    }
}
