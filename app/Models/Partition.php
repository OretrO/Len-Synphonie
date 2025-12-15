<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partition extends Model
{
    protected $table = 'partitions';

    protected $fillable = [
        'titre',
        'auteur',
        'chemin_fichier',
    ];
}
