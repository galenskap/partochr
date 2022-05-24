<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * Get all the songs that are tagged with this tag.
     */
    public function songs()
    {
        return $this->belongsToMany(Song::class, 'song_tag')->using(SongTag::class);
    }
}
