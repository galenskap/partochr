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

    public function list()
    {
        // get all songs // no filter, no order by, no pagination yet
        $songs = Song::all()->load('artist'); // add artist loading

        return Inertia::render('SongList', [
            'songs' => $songs,
        ]);
    }

    public function delete(Song $song)
    {
        $song->delete();

        return response()->json(array(
            'code' => 200,
            'message' => 'La chanson a bien été supprimée.',
        ), 200);
    }

    public function suggestSongName(Request $request)
    {
        // search for similar name
        $songs = Song::search($request->search)->within('title')->get();
        return response()->json(array(
            'code' => 200,
            'songs' => $songs,
        ), 200);
    }

    // Add or remove tag for given song
    public function updateTag(Song $song, Request $request)
    {
        $tag = $request->tag;
        // is given tag already in relationship with current song?
        if ($song->hasTag($tag)) {
            $song->tags()->detach($tag);
        } else {
            $song->tags()->attach($tag);
        }

        // reload object
        $song->load('tags');

        // return updated tags list for given song
        return response()->json(array(
            'code' => 200,
            'tags' => $song->tags,
        ), 200);
    }
}
