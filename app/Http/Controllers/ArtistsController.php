<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Song;
use Inertia\Inertia;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class ArtistsController extends Controller
{

    public function show(Artist $artist)
    {
        // get songs for this artist
        $artist->load('songs');

        return Inertia::render('Artist', [
            'artist' => $artist,
        ]);
    }

    public function list()
    {
        // get all artists
        $artists = Artist::withCount('songs')->orderBy('name', 'asc')->paginate(10);

        return Inertia::render('ArtistList', [
            'artists' => $artists,
        ]);
    }

    public function edit(Artist $artist, Request $request)
    {
        $artist->name = $request->name;
        $artist->save();

        return Redirect::route('artistpage', $artist);
    }

    public function delete(Artist $artist)
    {
        $artist->delete();

        return response()->json(array(
            'code' => 200,
            'message' => "L'artiste a bien été supprimé.",
        ), 200);
    }

    public function suggestArtistName(Request $request) {
        //search for similar name
        $artists = Artist::search($request->search)->within('name')->get();
        return response()->json(array(
            'code' => 200,
            'artists' => $artists,
        ), 200);
    }
}
