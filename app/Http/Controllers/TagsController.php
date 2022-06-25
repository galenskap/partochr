<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;


class TagsController extends Controller
{
/*     public function mytags(Request $request)
    {
        $user = $request->user();
        $tags = $user->tags()->get();

        return Inertia::render('Dashboard', [
            'tags' => $tags
        ]);
    } */

    public function show(Tag $tag)
    {
        // get songs for this tag
        $songs = $tag->songs()->get();
        $songs->load('artist');

        return Inertia::render('Tag', [
            'tag' => $tag,
            'songs' => $songs,
        ]);
    }
}
