<?php

namespace App\Http\Controllers;

use App\Http\Resources\SongResource;
use App\Models\Song;
use Illuminate\Http\Request;

class LikedSongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $songs = $request->user()->likedSongs()->get();

        return inertia('Songs/Liked/Index', [
            'songs' => SongResource::collection($songs)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Song $song)
    {
        $request->user()->likedSongs()->attach($song);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Song $song)
    {
        $request->user()->likedSongs()->detach($song);

        return response()->noContent();
    }
}
