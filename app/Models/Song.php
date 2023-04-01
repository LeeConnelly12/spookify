<?php

namespace App\Models;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Song extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * Get the artist that owns the song.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('medium')
            ->fit(Manipulations::FIT_CROP, 232, 232)
            ->format('webp')
            ->nonQueued();

        $this
            ->addMediaConversion('small')
            ->fit(Manipulations::FIT_CROP, 40, 40)
            ->format('webp')
            ->nonQueued();
    }
}
