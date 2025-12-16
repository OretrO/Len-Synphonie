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
     * RELATION 1: Get the arrangements created by the user (relation directe).
     * Cardinalité: 1 User -> * Arrangements
     */
    public function arrangements()
    {
        return $this->hasMany(Arrangement::class, 'creator_id');
    }

    /**
     * Get the partitions created by the user.
     * Cardinalité: 1 User -> * Partitions
     */
    public function partitions()
    {
        return $this->hasMany(Partition::class);
    }

    /**
     * RELATION 2: Get the arrangements appreciated by the user (via classe associative Appreciation).
     * Cardinalité: * Users <-> * Arrangements (via appreciations)
     */
    public function appreciatedArrangements()
    {
        return $this->belongsToMany(Arrangement::class, 'appreciations')
            ->using(Appreciation::class)
            ->withPivot('is_like')
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
}

