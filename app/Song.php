<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'alt_title', 'year',
    ];

    /**
     * Get the sheets corresponding to the song
     */
    public function sheets()
    {
        return $this->hasMany(Sheet::class);
    }

    /**
     * The artists who did the song
     */
    public function artists()
    {
        return $this->belongsToMany(Artist::class);
    }

    /**
     * The tags put on the song
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
