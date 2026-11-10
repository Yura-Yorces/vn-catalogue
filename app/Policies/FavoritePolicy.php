<?php

namespace App\Policies;

use App\Models\Favorite;
use App\Models\User;

class FavoritePolicy
{
    public function create(User $user): bool
    {
        return true;
    }

    public function delete(User $user, Favorite $favorite): bool
    {
        return $user->id === $favorite->user_id;
    }
}
