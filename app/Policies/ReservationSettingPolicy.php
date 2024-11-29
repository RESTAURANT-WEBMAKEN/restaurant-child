<?php

namespace App\Policies;

use App\Models\ReservationSetting;
use App\Models\User;

class ReservationSettingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->isAdmin();
    }

    /**
     * Determine whether the user can view a specific model.
     */
    public function view(User $user, ReservationSetting $reservationSetting): bool
    {
        return $user->role->isAdmin();
    }

    /**
     * Determine whether the user can create a model.
     */
    public function create(User $user): bool
    {
        return $user->role->isAdmin();
    }

    /**
     * Determine whether the user can update a specific model.
     */
    public function update(User $user, ReservationSetting $reservationSetting): bool
    {
        return $user->role->isAdmin();
    }

    /**
     * Determine whether the user can delete a specific model.
     */
    public function delete(User $user, ReservationSetting $reservationSetting): bool
    {
        return $user->role->isAdmin();
    }

    /**
     * Determine whether the user can delete multiple models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->role->isAdmin();
    }

    /**
     * Determine whether the user can force delete a soft-deleted model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->role->isAdmin();
    }

    /**
     * Determine whether the user can force delete multiple models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->role->isAdmin();
    }

    /**
     * Determine whether the user can reorder models.
     */
    public function reorder(User $user): bool
    {
        return $user->role->isAdmin();
    }

    /**
     * Determine whether the user can duplicate a model.
     */
    public function replicate(User $user): bool
    {
        return $user->role->isAdmin();
    }

    /**
     * Determine whether the user can restore a soft-deleted model.
     */
    public function restore(User $user, ReservationSetting $reservationSetting): bool
    {
        return $user->role->isAdmin();
    }

    /**
     * Determine whether the user can restore multiple soft-deleted models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->role->isAdmin();
    }
}
