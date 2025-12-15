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
        'genre',
        'description',
        'original_file_path',
    ];

    /**
     * Get the arrangements for the partition.
     */
    public function arrangements()
    {
        return $this->hasMany(Arrangement::class);
    }
}

class Partition extends Model
{
    protected $table = 'partitions';

    protected $fillable = [
        'titre',
        'auteur',
        'chemin_fichier',
    ];
}
