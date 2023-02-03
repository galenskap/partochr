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
        // get all artists // no filter, no order by, no pagination yet
        $artists = Artist::withCount('songs')->get();

        return Inertia::render('ArtistList', [
            'artists' => $artists,
        ]);
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
