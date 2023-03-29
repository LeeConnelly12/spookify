<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlaylistSongController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Playlist $playlist)
    {
        $request->validate([
            'song_id' => ['required', Rule::exists('songs', 'id')],
        ]);

        $playlist->songs()->attach($request->song_id);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Playlist $playlist)
    {
        $request->validate([
            'song_id' => ['required', Rule::exists('songs', 'id')],
        ]);

        $playlist->songs()->detach($request->song_id);

        return back();
    }
}
