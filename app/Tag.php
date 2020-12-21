<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
    ];

    /**
     * The songs that belong to the tag
     */
    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }
}
