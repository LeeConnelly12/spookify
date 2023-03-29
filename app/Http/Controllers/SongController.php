<?php

namespace App\Http\Controllers;

use App\Http\Resources\SongResource;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $songs = Song::query()->get();

        return inertia('Songs/Index', [
            'songs' => SongResource::collection($songs),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Song $song)
    {
        return inertia('Songs/Show', [
            'song' => new SongResource($song),
        ]);
    }
}
