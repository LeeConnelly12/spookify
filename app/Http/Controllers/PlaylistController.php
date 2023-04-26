<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlaylistResource;
use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $playlists = $request->user()->playlists()->get();

        return inertia('Playlists/Index', [
            'playlists' => PlaylistResource::collection($playlists),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Playlists/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $count = $request->user()->playlists()->count() + 1;

        $playlist = $request->user()
            ->playlists()
            ->create([
                'name' => 'My Playlist #'.$count,
            ]);

        return to_route('playlists.show', $playlist);
    }

    /**
     * Display the specified resource.
     */
    public function show(Playlist $playlist)
    {
        $playlist->load('user', 'songs.user', 'songs.album');

        return inertia('Playlists/Show', [
            'playlist' => new PlaylistResource($playlist),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Playlist $playlist)
    {
        return inertia('Playlists/Edit', [
            'playlist' => new PlaylistResource($playlist),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Playlist $playlist)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
        ]);

        $playlist->update([
            'name' => $request->name,
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Playlist $playlist)
    {
        $playlist->delete();

        return to_route('home');
    }
}
