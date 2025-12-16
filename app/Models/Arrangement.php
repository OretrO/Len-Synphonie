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
        'name',
        'instruments_config',
        'audio_file_path',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'instruments_config' => 'array',
    ];

    /**
     * Get the partition that owns the arrangement.
     */
    public function partition()
    {
        return $this->belongsTo(Partition::class);
    }

    /**
     * RELATION 1: Get the creator (user) of the arrangement (relation directe).
     * Cardinalité: * Arrangements -> 1 User
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
     * Get the comments for the arrangement.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the appreciations for the arrangement.
     */
    public function appreciations()
    {
        return $this->hasMany(Appreciation::class);
    }

    /**
     * RELATION 2: Get the users who appreciated this arrangement (via classe associative Appreciation).
     * Cardinalité: * Arrangements <-> * Users (via appreciations)
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
