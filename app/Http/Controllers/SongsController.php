<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Song;
use Inertia\Inertia;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function newSongPage(Request $request)
    {
        return Inertia::render('NewSong');
    }

    public function newSongCreate(Request $request)
    {
        $song = new Song;
        $song->title = $request->title;
        $song->lyrics = $request->lyrics;
        $song->year = $request->year;
        $song->user_id = Auth::user()->id;

        // get artist by name
        $artist = Artist::where('name', $request->artist)->get()->first();
        // if no exact match, then create it
        if (!$artist) {
            // create artist
            $artist = new Artist;
            $artist->name = $request->artist;
            $artist->save();
        }

        $song->artist_id = $artist->id;
        $song->save();

        return Redirect::route('songpage', $song);
    }

    public function edit(Song $song, Request $request)
    {
        $song->title = $request->title;
        $song->lyrics = $request->lyrics;
        $song->year = $request->year;

        // get artist by name
        $artist = Artist::where('name', $request->artist)->get()->first();
        // if no exact match, then create it
        if (!$artist) {
            // create artist
            $artist = new Artist;
            $artist->name = $request->artist;
            $artist->save();
        }

        $song->artist_id = $artist->id;
        $song->save();

        return Redirect::route('songpage', $song);
    }

    public function suggestArtistName(Request $request) {
        //search for similar name
        $artists = Artist::where('name', 'LIKE', '%'.$request->search.'%')->get();
        return response()->json(array(
            'code' => 200,
            'artists' => $artists,
        ), 200);
    }
}
