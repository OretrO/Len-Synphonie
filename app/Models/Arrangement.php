<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Arrangement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'partition_id',
        'user_id',
        'name',
        'instruments_config',
        'audio_file_path',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'instruments_config' => 'array',
        ];
    }

    /**
     * Get the partition that owns the arrangement.
     */
    public function partition(): BelongsTo
    {
        return $this->belongsTo(Partition::class);
    }

    /**
     * Get the user that created the arrangement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for the arrangement.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the likes for the arrangement.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
}

