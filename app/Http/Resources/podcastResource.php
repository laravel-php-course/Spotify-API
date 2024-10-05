<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class podcastResource extends JsonResource
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
            'show' => new showResource($this->show) ,
            'artist' => new artistResource($this->artist) ,
            'cover' => $this->cover ,
            'file' => $this->file ,
            'lyric' => $this->lyric ,
            'About' => $this->About ,
        ];
    }
}
