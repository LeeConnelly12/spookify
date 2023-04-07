<?php

use App\Http\Controllers\SongController;
use App\Models\Song;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\LikedSongController;
use App\Http\Controllers\PlaylistSongController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Playlists
Route::get('/playlists', [PlaylistController::class, 'index'])
    ->name('playlists')
    ->middleware('auth');

Route::get('/playlists/create', [PlaylistController::class, 'create'])
    ->name('playlists.create')
    ->middleware('auth');

Route::post('/playlists', [PlaylistController::class, 'store'])
    ->name('playlists.store')
    ->middleware('auth');

Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])
    ->name('playlists.show')
    ->middleware('auth');

Route::get('/playlists/{playlist}/edit', [PlaylistController::class, 'edit'])
    ->name('playlists.edit')
    ->middleware('auth');

Route::put('/playlists/{playlist}', [PlaylistController::class, 'update'])
    ->name('playlists.update')
    ->middleware('auth');

Route::delete('/playlists/{playlist}', [PlaylistController::class, 'destroy'])
    ->name('playlists.destroy')
    ->middleware('auth');

Route::post('/playlists/{playlist}/songs', [PlaylistSongController::class, 'store'])
    ->name('playlists.songs.store')
    ->middleware('auth');

Route::delete('/playlists/{playlist}/songs', [PlaylistSongController::class, 'destroy'])
    ->name('playlists.songs.destroy')
    ->middleware('auth');

// Songs
Route::get('/', [SongController::class, 'index'])
    ->name('home');

Route::get('/songs/create', [SongController::class, 'create'])
    ->name('songs.create')
    ->middleware('auth');

Route::get('/songs/{song}', [SongController::class, 'show'])
    ->name('songs.show');

Route::post('/songs', [SongController::class, 'store'])
    ->name('songs.store')
    ->middleware('role:artist');

Route::get('/songs/{song}/edit', [SongController::class, 'edit'])
    ->name('songs.edit')
    ->can('update', 'song');

Route::put('/songs/{song}', [SongController::class, 'update'])
    ->name('songs.update')
    ->can('update', 'song');

Route::delete('/songs/{song}', [SongController::class, 'destroy'])
    ->name('songs.destroy')
    ->can('update', 'song');

Route::get('/songs', [LikedSongController::class, 'index'])
    ->name('songs')
    ->middleware('auth');

Route::put('/songs/{song}/like', [LikedSongController::class, 'update'])
    ->name('liked-songs.update')
    ->middleware('auth');

Route::delete('/songs/{song}/unlike', [LikedSongController::class, 'destroy'])
    ->name('liked-songs.destroy')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
