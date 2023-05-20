<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SongResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'year' => $this->year,
            'url' => $this->getFirstMediaUrl('file'),
            'artist' => new UserResource($this->whenLoaded('user')),
            'album' => new AlbumResource($this->whenLoaded('album')),
            'small_image' => $this->getFirstMediaUrl('image', 'small'),
            'medium_image' => $this->getFirstMediaUrl('image', 'medium'),
            'duration' => $this->duration,
            'liked' => $this->whenLoaded('likedByUsers', function () {
                return $this->likedByUsers->isNotEmpty();
            }),
            'added' => $this->whenPivotLoaded('playlist_song', function () {
                return $this->pivot->created_at->diffForHumans();
            }),
        ];
    }
}
