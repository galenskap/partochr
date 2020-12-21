<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename', 'nb_views',
    ];

    /**
     * Get the song corresponding to the sheet.
     */
    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    /**
     * The users who liked the sheet
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
