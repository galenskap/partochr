<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Tag;
use App\Models\Artist;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class SearchController extends Controller
{
    public function globalSearch(Request $request)
    {
        // search for the keyword in...

        // Songs : title, lyrics
        $songs = Song::search($request->search)->get();

        // Tags : name
        $tags = Tag::search($request->search)->get();

        // Artists : name
        $artists = Artist::search($request->search)->get();

        return response()->json(array(
            'code' => 200,
            'songs' => $songs,
            'tags' => $tags,
            'artists' => $artists,
        ), 200);
    }
}
