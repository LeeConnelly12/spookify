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

    /**
     * Get the album that owns the song.
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    /**
     * Get the song's duration.
     */
    public function formattedDuration(): string
    {
        return str($this->duration / 100)->replace('.', ':');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile();

        $this
            ->addMediaCollection('file')
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
            ->fit(Manipulations::FIT_CROP, 65, 65)
            ->format('webp')
            ->nonQueued();
    }
}
