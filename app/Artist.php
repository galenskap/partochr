<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'firstname',
    ];

    /**
     * The songs that belong to the artist
     */
    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }
}
