<?php

namespace App\Models;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * Interact with the song's duration.
     */
    protected function duration(): Attribute
    {
        return Attribute::make(
            get: function (string $seconds) {
                return $seconds;
            },
            set: function (string $seconds) {
                $minutes = floor(($seconds / 60) % 60);
                $seconds = $seconds % 60;
                $seconds = $seconds < 10 ? '0'.$seconds : $seconds;
                return $minutes.':'.$seconds;
            },
        );
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
