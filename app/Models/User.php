<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the arrangements created by the user.
     */
    public function createdArrangements()
    {
        return $this->hasMany(Arrangement::class, 'creator_id');
    }

    /**
     * Get the arrangements that the user supports.
     */
    public function supportedArrangements()
    {
        return $this->belongsToMany(Arrangement::class, 'user_arrangements')
            ->withTimestamps();
    }

    /**
     * Get the comments written by the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the appreciations given by the user.
     */
    public function appreciations()
    {
        return $this->hasMany(Appreciation::class);
    }

    /**
     * Get the arrangements liked by the user.
     */
    public function likedArrangements()
    {
        return $this->belongsToMany(Arrangement::class, 'appreciations')
            ->using(Appreciation::class)
            ->withPivot('is_like')
            ->withTimestamps();
    }
}

