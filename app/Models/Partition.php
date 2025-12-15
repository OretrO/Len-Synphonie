<?php
}
    }
        return $this->hasMany(Arrangement::class);
    {
    public function arrangements(): HasMany
     */
     * Get the arrangements for the partition.
    /**

    }
        return $this->belongsTo(User::class);
    {
    public function user(): BelongsTo
     */
     * Get the user that created the partition.
    /**

    ];
        'user_id',
        'musicxml_file_path',
        'composer',
        'title',
    protected $fillable = [
     */
     * @var list<string>
     *
     * The attributes that are mass assignable.
    /**

    use HasFactory;
{
class Partition extends Model

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

namespace App\Models;


