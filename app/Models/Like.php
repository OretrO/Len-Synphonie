<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'arrangement_id',
        'user_id',
        'is_like',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_like' => 'boolean',
        ];
    }

    /**
     * Get the arrangement that owns the like.
     */
    public function arrangement(): BelongsTo
    {
        return $this->belongsTo(Arrangement::class);
    }

    /**
     * Get the user that created the like.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

