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
            'url' => Storage::url($this->url),
            $this->mergeWhen($request->user(), function () use ($request) {
                return [
                    'liked' => $request->user()->likedSongs->contains($this->resource),
                ];
            }),
        ];
    }
}
