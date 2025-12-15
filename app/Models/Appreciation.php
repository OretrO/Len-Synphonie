<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Appreciation extends Pivot
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appreciations';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'arrangement_id',
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
     * Get the user that gave the appreciation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the arrangement that was appreciated.
     */
    public function arrangement()
    {
        return $this->belongsTo(Arrangement::class);
    }
}

