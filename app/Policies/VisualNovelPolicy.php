<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VisualNovel;
use Illuminate\Auth\Access\Response;

class VisualNovelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, VisualNovel $visualNovel): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isStaff();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, VisualNovel $visualNovel): bool
    {
        return $user->isStaff();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, VisualNovel $visualNovel): bool
    {
        return $user->isStaff();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, VisualNovel $visualNovel): bool
    {
        return $user->role === User::ROLE_ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, VisualNovel $visualNovel): bool
    {
        return $user->role === User::ROLE_ADMIN;
    }
}
