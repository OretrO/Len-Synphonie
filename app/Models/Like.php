<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'arrangement_id',
    ];

    /**
     * Get the arrangement that this like is for.
     */
    public function arrangement()
    {
        return $this->belongsTo(Arrangement::class);
    }

    /**
     * Get the appreciations for this like.
     */
    public function appreciations()
    {
        return $this->hasMany(Appreciation::class);
    }

    /**
     * Get the users who gave appreciations for this like.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'appreciations')
            ->using(Appreciation::class)
            ->withPivot('is_like')
            ->withTimestamps();
    }

    /**
     * Get the count of likes.
     */
    public function likesCount()
    {
        return $this->appreciations()->where('is_like', true)->count();
    }

    /**
     * Get the count of dislikes.
     */
    public function dislikesCount()
    {
        return $this->appreciations()->where('is_like', false)->count();
    }
}

