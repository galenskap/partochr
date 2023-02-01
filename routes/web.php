<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ArtistsController;
use App\Http\Controllers\SongsController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserController;

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

// dashboard with my tags
Route::get('/', [UserController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('home');

// SONGS
// song creation
Route::get('songs/new', [SongsController::class, 'newSongPage'])->middleware(['auth', 'verified'])->name('new-song-page');
Route::post('songs/new', [SongsController::class, 'newSongCreate'])->middleware(['auth', 'verified'])->name('new-song-create');
// show specific song page
Route::get('songs/{song}', [SongsController::class, 'show'])->middleware(['auth', 'verified'])->name('songpage');
// song edition
Route::post('songs/{song}/edit', [SongsController::class, 'edit'])->middleware(['auth', 'verified'])->name('songedition');
// show all songs
Route::get('songs', [SongsController::class, 'list'])->middleware(['auth', 'verified'])->name('songlist');
// add or remove tag to song
Route::post('songs/{song}/tags/update', [SongsController::class, 'updateTag'])->middleware(['auth', 'verified'])->name('songtag-update');

// TAGS
// show specific tag page
Route::get('tags/{tag}', [TagsController::class, 'show'])->middleware(['auth', 'verified'])->name('tagpage');
// show all tags
Route::get('tags', [TagsController::class, 'list'])->middleware(['auth', 'verified'])->name('taglist');
// search
Route::post('tags/search', [TagsController::class, 'suggestTagName'])->middleware(['auth', 'verified'])->name('tagsearch');

// ARTISTS
// show specific artist page
Route::get('artists/{artist}', [ArtistsController::class, 'show'])->middleware(['auth', 'verified'])->name('artistpage');
// show all artists
Route::get('artists', [ArtistsController::class, 'list'])->middleware(['auth', 'verified'])->name('artistlist');

// API
Route::post('search-artist', [ArtistsController::class, 'suggestArtistName'])->middleware(['auth', 'verified'])->name('artistsuggestion');

require __DIR__.'/auth.php';
