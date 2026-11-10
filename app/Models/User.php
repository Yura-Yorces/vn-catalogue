<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// #[Fillable(['name', 'email', 'password'])]
// #[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    public const ROLE_USER = 'user';
    public const ROLE_MODERATOR = 'moderator';
    public const ROLE_ADMIN = 'admin';


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected $fillable = [
        'nickname',
        'username',
        'password',
        'role',
        'banned_until',
        'ban_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'banned_until' => 'datetime',
        ];
    }

    public function isStaff(): bool
    {
        return in_array($this->role, [self::ROLE_MODERATOR, self::ROLE_ADMIN], true);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isBanned(): bool
    {
        if (! $this->trashed()) {
            return false;
        }

        return $this->banned_until === null || $this->banned_until->isFuture();
    }

    public function banExpired(): bool
    {
        return $this->trashed()
            && $this->banned_until !== null
            && $this->banned_until->isPast();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(VisualNovel::class, 'favorites')->withTimestamps();
    }
}
