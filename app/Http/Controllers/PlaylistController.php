<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlaylistResource;
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
}
