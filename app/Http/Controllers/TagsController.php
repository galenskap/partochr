<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


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

    public function newTagPage(Request $request)
    {
        return Inertia::render('NewTag');
    }

    public function newTagCreate(Request $request)
    {
        $tag = new Tag;
        $tag->name = $request->name;
        // in V1, all the tags created are automatically public
        // later version may change this (if we want the possibility to have tags that can only be seen by they owners)
        // but the "owning" relationship does not exists so far.

        $tag->save();

        // automatically add the created tag to the user's followed tags
        $user = Auth::user();
        $user->tags()->attach($tag);

        return Redirect::route('tagpage', $tag);
    }

    public function edit(Tag $tag, Request $request)
    {
        $tag->name = $request->name;
        $tag->save();

        return Redirect::route('tagpage', $tag);
    }

    public function delete(Tag $tag, Request $request)
    {
        $tag->delete();

        return response()->json(array(
            'code' => 200,
            'message' => 'Le classeur a bien été supprimé.',
        ), 200);
    }

    public function suggestTagName(Request $request)
    {
        // search for similar name
        $tags = Tag::search($request->search)->within('name')->get()->load('songs');
        return response()->json(array(
            'code' => 200,
            'tags' => $tags,
        ), 200);
    }


    // Add or remove tag for current user
    public function updateFav(Tag $tag, Request $request)
    {
        $user = Auth::user();

        // is given tag already in relationship with current user?
        if ($user->hasTag($tag)) {
            $user->tags()->detach($tag);
        } else {
            $user->tags()->attach($tag);
        }

        // return updated tags list for given song
        return response()->json(array(
            'code' => 200,
            'tag' => $tag,
        ), 200);
    }
}
