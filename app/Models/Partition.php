<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'composer',
        'musicxml_file_path',
        'musicpdf_file_path',
        'user_id',
        'genre',
    ];

    /**
     * Get the user who created the partition.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the arrangements for the partition.
     */
    public function arrangements()
    {
        return $this->hasMany(Arrangement::class);
    }
}
