<?php

namespace App\Http\Controllers;

use App\Http\Resources\SongResource;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $songs = Song::query()
            ->with('user', 'media')
            ->get();

        return inertia('Songs/Index', [
            'songs' => SongResource::collection($songs),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Songs/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'year' => ['required', 'integer', 'min:0', 'max:3000'],
            'file' => ['required', File::types('mp3')->max(5120)],
            'image' => ['required', File::types(['jpg', 'png'])->max(5120)],
        ]);

        $song = $request->user()->songs()->create([
            'name' => $request->name,
            'year' => $request->year,
            'duration' => FFMpeg::open($request->file('file'))->getDurationInSeconds(),
        ]);

        $song
            ->addMediaFromRequest('file')
            ->toMediaCollection('file');

        $song
            ->addMediaFromRequest('image')
            ->toMediaCollection('image');

        return to_route('songs.show', $song);
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
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        return inertia('Songs/Edit', [
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
            'file' => [File::types('mp3')->max(5120)],
            'image' => [File::types(['jpg', 'png'])->max(5120)],
        ]);

        $song->fill([
            'name' => $request->name,
            'year' => $request->year,
        ]);

        if ($request->hasFile('file')) {
            $song->duration = FFMpeg::open($request->file('file'))->getDurationInSeconds();

            $song
                ->addMediaFromRequest('file')
                ->toMediaCollection('file');
        }

        if ($request->hasFile('image')) {
            $song
                ->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        $song->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Song $song)
    {
        $song->delete();

        return back();
    }
}
