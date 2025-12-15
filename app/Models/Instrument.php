<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category',
        'description',
    ];

    /**
     * Get the arrangements that use this instrument.
     */
    public function arrangements()
    {
        return $this->belongsToMany(Arrangement::class, 'arrangement_instruments')
            ->withPivot('track_number')
            ->withTimestamps();
    }
}

