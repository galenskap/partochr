<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * The accessors to append to or remove from the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_in_favourites'];
    protected $hidden = ['users'];

    /**
     * Modify the query used to retrieve models when making all of the models searchable.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function makeAllSearchableUsing($query)
    {
        return $query->with('songs');
    }

    /**
     * Get all the songs that are tagged with this tag.
     */
    public function songs()
    {
        return $this->belongsToMany(Song::class, 'song_tag');
    }

    /**
     * Get all the users that are following this tag.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tag');
    }

    /**
     * Say if the current user has put this tag in his favourites
     */
    public function getIsInFavouritesAttribute()
    {
        return $this->users->contains(Auth::user()->id);
    }

}
