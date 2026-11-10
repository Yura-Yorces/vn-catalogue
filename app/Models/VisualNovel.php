<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

class VisualNovel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'cover_image',
        'developer',
        'publisher',
        'description',
        'release_date',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
