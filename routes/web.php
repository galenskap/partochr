<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
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
// show specific tag page
Route::get('tags/{tag}', [TagsController::class, 'show'])->middleware(['auth', 'verified'])->name('tagpage');
// show specific song page
Route::get('songs/{song}', [SongsController::class, 'show'])->middleware(['auth', 'verified'])->name('songpage');
// edit song
Route::post('songs/{song}/edit', [SongsController::class, 'edit'])->middleware(['auth', 'verified'])->name('songedition');

require __DIR__.'/auth.php';
