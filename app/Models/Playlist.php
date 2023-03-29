<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Playlist extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the playlist.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
