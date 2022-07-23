<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;


class TagsController extends Controller
{
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

    public function list()
    {
        // get all tags // no filter, no order by, no pagination yet
        $tags = Tag::withCount('songs')->get();

        return Inertia::render('TagList', [
            'tags' => $tags,
        ]);
    }
}
