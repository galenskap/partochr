<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Song;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


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

    public function edit(Song $song, Request $request)
    {
        $song->title = $request->title;
        $song->lyrics = $request->lyrics;
        $song->save();
        return Redirect::route('songpage', $song);
    }
}
