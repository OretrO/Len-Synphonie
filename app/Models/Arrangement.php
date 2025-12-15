<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
     * Get the comments for the arrangement.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the instruments used in this arrangement.
     */
    public function instruments(): BelongsToMany
    {
        return $this->belongsToMany(Instrument::class, 'arrangement_instruments')
            ->withPivot('track_number')
            ->withTimestamps();
    }

    /**
     * Get the users associated with this arrangement via user_arrangements.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_arrangements')
            ->withTimestamps();
    }

    /**
     * Get the user arrangements for this arrangement.
     */
    public function userArrangements(): HasMany
    {
        return $this->hasMany(UserArrangement::class);
    }
}