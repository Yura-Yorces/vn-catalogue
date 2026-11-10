<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    public function ban(User $user, User $model): bool
    {
        return $user->isStaff()
            && $model->role === User::ROLE_USER
            && $model->id !== $user->id;
    }

    public function restore(User $user, User $model): bool
    {
        return $user->isStaff()
            && $model->role === User::ROLE_USER
            && $model->id !== $user->id;
    }

    public function changeRole(User $user, User $model): bool
    {
        return $user->isAdmin()
            && $model->id !== $user->id;
    }
}
