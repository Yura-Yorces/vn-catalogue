<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Favorite extends Model
{
    /** @use HasFactory<\Database\Factories\FavoriteFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'visual_novel_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function visualNovel(): BelongsTo
    {
        return $this->belongsTo(VisualNovel::class);
    }
}
