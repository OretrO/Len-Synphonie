<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arrangement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'partition_id',
        'creator_id',
        'title',
        'description',
        'difficulty_level',
        'file_path',
        'is_public',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    /**
     * Get the partition that owns the arrangement.
     */
    public function partition()
    {
        return $this->belongsTo(Partition::class);
    }

    /**
     * Get the creator (user) of the arrangement.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the instruments associated with the arrangement.
     */
    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'arrangement_instruments')
            ->withPivot('track_number')
            ->withTimestamps();
    }

    /**
     * Get the users supporting this arrangement.
     */
    public function supporters()
    {
        return $this->belongsToMany(User::class, 'user_arrangements')
            ->withTimestamps();
    }

    /**
     * Get the comments for the arrangement.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the likes for the arrangement.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get the appreciations for the arrangement.
     */
    public function appreciations()
    {
        return $this->hasMany(Appreciation::class);
    }

    /**
     * Get the users who liked/disliked this arrangement.
     */
    public function appreciators()
    {
        return $this->belongsToMany(User::class, 'appreciations')
            ->using(Appreciation::class)
            ->withPivot('is_like')
            ->withTimestamps();
    }

    /**
     * Get the count of likes for this arrangement.
     */
    public function likesCount()
    {
        return $this->appreciations()->where('is_like', true)->count();
    }

    /**
     * Get the count of dislikes for this arrangement.
     */
    public function dislikesCount()
    {
        return $this->appreciations()->where('is_like', false)->count();
    }
}

