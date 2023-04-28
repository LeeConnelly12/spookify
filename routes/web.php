<?php

use App\Models\Song;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\SongController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\AlbumSongController;
use App\Http\Controllers\LikedSongController;
use App\Http\Controllers\PlaylistSongController;
use App\Http\Controllers\PlaylistImageController;

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

Route::get('/auth/redirect', function () {
    // return Socialite::driver('discord')->redirect();

    $redirectUrl = Socialite::driver('discord')->redirect()->getTargetUrl();
    return response('', 409)->header('X-Inertia-Location', $redirectUrl);
});

Route::get('/auth/callback', function () {
    $discordUser = Socialite::driver('discord')->user();

    $user = User::updateOrCreate([
        'discord_id' => $discordUser->getId(),
    ], [
            'name' => $discordUser->getName(),
            'email' => $discordUser->getEmail(),
            'password' => bcrypt(Str::password()),
        ]);

    $user
        ->addMediaFromUrl($discordUser->avatar)
        ->toMediaCollection('profile_picture');

    Auth::login($user);

    return to_route('home');
});

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

Route::post('/playlists/{playlist}/images', [PlaylistImageController::class, 'store'])
    ->name('playlists.images.store')
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

// Albums
Route::get('/albums/{album}', [AlbumController::class, 'show'])
    ->name('albums.show');

Route::post('/albums/{album}/songs', [AlbumSongController::class, 'store'])
    ->name('albums.songs.store')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');
});

require __DIR__ . '/auth.php';
