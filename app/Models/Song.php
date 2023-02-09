<?php

namespace App\Models;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Song extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * The tags that are labeled to the song.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Check if the song has a given tag
     */
    public function hasTag($tag) {
        return $this->tags->contains($tag);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
