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

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
