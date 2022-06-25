<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Song;
use Inertia\Inertia;
use Illuminate\Http\Request;


class SongsController extends Controller
{

    public function show(Song $song)
    {
        $song->load('artist');
        // get tags for this song
        $song->load('tags');

        return Inertia::render('Song', [
            'song' => $song,
        ]);
    }
}
