<?php

namespace App\Models;

use App\Models\Tag;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * The tags that are followed by the user.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'user_tag');
    }

    /**
     * The songs that the user has created.
     */
    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    /**
     * Latest songs that the user has modified.
     */
    public function latestSongs()
    {
        return $this->hasMany(Song::class)->latest('updated_at')->limit(5);
    }

    /**
     * Check if the user is following a given tag
     */
    public function hasTag($tag)
    {
        return $this->tags->contains($tag);
    }
}
