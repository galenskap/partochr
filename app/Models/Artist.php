<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Artist extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * Get all the songs belonging to this artist.
     */
    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
