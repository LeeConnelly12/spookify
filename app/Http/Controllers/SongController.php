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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'year' => ['required', 'integer', 'min:0', 'max:3000'],
        ]);

        $request->user()->songs()->create([
            'name' => $request->name,
            'year' => $request->year,
        ]);

        return back();
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Song $song)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'year' => ['required', 'integer', 'min:0', 'max:3000'],
        ]);

        $song->update([
            'name' => $request->name,
            'year' => $request->year,
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Song $song)
    {
        $song->delete();

        return to_route('songs');
    }
}
