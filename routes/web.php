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
// show all songs
Route::get('songs', [SongsController::class, 'list'])->middleware(['auth', 'verified'])->name('songlist');
// show specific song page
Route::get('songs/{song}', [SongsController::class, 'show'])->middleware(['auth', 'verified'])->name('songpage');
// song edition
Route::post('songs/{song}/edit', [SongsController::class, 'edit'])->middleware(['auth', 'verified'])->name('songedition');
// search
Route::post('songs/search', [SongsController::class, 'suggestSongName'])->middleware(['auth', 'verified'])->name('songsuggestion');
// add or remove tag to song
Route::post('songs/{song}/tags/update', [SongsController::class, 'updateTag'])->middleware(['auth', 'verified'])->name('songtag-update');
// delete song
Route::delete('songs/{song}', [SongsController::class, 'delete'])->middleware(['auth', 'verified'])->name('songdeletion');

// TAGS
// tag creation
Route::get('tags/new', [TagsController::class, 'newTagPage'])->middleware(['auth', 'verified'])->name('new-tag-page');
Route::post('tags/new', [TagsController::class, 'newTagCreate'])->middleware(['auth', 'verified'])->name('new-tag-create');
// show all tags
Route::get('tags', [TagsController::class, 'list'])->middleware(['auth', 'verified'])->name('taglist');
// show specific tag page
Route::get('tags/{tag}', [TagsController::class, 'show'])->middleware(['auth', 'verified'])->name('tagpage');
// tag edition
Route::post('tags/{tag}/edit', [TagsController::class, 'edit'])->middleware(['auth', 'verified'])->name('tagedition');
// search
Route::post('tags/search', [TagsController::class, 'suggestTagName'])->middleware(['auth', 'verified'])->name('tagsearch');
// add or remove song to tag
Route::post('tags/{tag}/songs/update', [TagsController::class, 'updateSong'])->middleware(['auth', 'verified'])->name('tagsong-update');
// add or remove tag following for current user
Route::post('tags/{tag}/users/update', [TagsController::class, 'updateFav'])->middleware(['auth', 'verified'])->name('tagfav');
// delete tag
Route::delete('tags/{tag}', [TagsController::class, 'delete'])->middleware(['auth', 'verified'])->name('tagdeletion');


// ARTISTS
// show all artists
Route::get('artists', [ArtistsController::class, 'list'])->middleware(['auth', 'verified'])->name('artistlist');
// show specific artist page
Route::get('artists/{artist}', [ArtistsController::class, 'show'])->middleware(['auth', 'verified'])->name('artistpage');
// artist edition
Route::post('artists/{artist}/edit', [ArtistsController::class, 'edit'])->middleware(['auth', 'verified'])->name('artistedition');
// search
Route::post('artists/search', [ArtistsController::class, 'suggestArtistName'])->middleware(['auth', 'verified'])->name('artistsuggestion');
// delete artist
Route::delete('artists/{artist}', [ArtistsController::class, 'delete'])->middleware(['auth', 'verified'])->name('artistdeletion');

require __DIR__.'/auth.php';
