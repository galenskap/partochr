<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Song;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class TagsController extends Controller
{
    public function show(Tag $tag)
    {
        // get songs and their artists name for this tag
        $tag->load('songs.artist');

        return Inertia::render('Tag', [
            'tag' => $tag,
        ]);
    }

    public function list()
    {
        // get all tags
        $tags = Tag::withCount('songs')->orderBy('created_at', 'asc')->paginate(10);

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

    // Add or remove song to given tag
    public function updateSong(Tag $tag, Request $request)
    {
        // we may have two different formats for the request
        if (is_array($request["song"]) && array_key_exists("id", $request["song"])) {
            $song = Song::find($request["song"]["id"]);
        } else {
            $song = Song::find($request->song);
        }

        // is given tag already in relationship with current song?
        if ($song->hasTag($tag)) {
            $song->tags()->detach($tag);
        } else {
            $song->tags()->attach($tag);
        }

        // reload object
        $tag->load('songs.artist');

        // return updated songs list for given tag
        return response()->json(array(
            'code' => 200,
            'songs' => $tag->songs,
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
