<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use App\Http\Resources\AlbumResource;

class AlbumController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        return inertia('Albums/Show', [
            'album' => new AlbumResource($album),
        ]);
    }
}
