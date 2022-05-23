<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\SongTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Song extends Model
{
    use HasFactory;

    /**
     * The tags that are labeled to the song.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->using(SongTag::class);
    }
}