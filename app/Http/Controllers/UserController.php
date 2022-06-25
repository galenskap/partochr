<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $tags = $user->tags()->withCount('songs')->get();
        $songs = $user->latestSongs()->get();
        $songs->load('artist');

        return Inertia::render('Dashboard', [
            'tags' => $tags,
            'songs' => $songs
        ]);
    }
}
