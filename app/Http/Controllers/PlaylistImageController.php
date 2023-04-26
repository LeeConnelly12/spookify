<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;

class PlaylistImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Playlist $playlist)
    {
        $request->validate([
            'image' => ['required', File::types(['jpg', 'png'])->max(5120)],
        ]);

        $playlist
            ->addMediaFromRequest('image')
            ->toMediaCollection('image');

        return back();
    }
}
