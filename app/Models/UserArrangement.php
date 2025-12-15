<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserArrangement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'arrangement_id',
    ];

    /**
     * Get the user that owns the user arrangement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the arrangement that owns the user arrangement.
     */
    public function arrangement(): BelongsTo
    {
        return $this->belongsTo(Arrangement::class);
    }

    /**
     * Get the appreciations for this user arrangement.
     */
    public function appreciations(): HasMany
    {
        return $this->hasMany(Appreciation::class);
    }
}

