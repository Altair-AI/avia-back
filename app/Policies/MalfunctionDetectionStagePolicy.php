<?php

namespace App\Policies;

use App\Models\MalfunctionDetectionStage;
use App\Models\User;

class MalfunctionDetectionStagePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->role !== User::GUEST_ROLE;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param MalfunctionDetectionStage $malfunctionDetectionStage
     * @return bool
     */
    public function view(User $user, MalfunctionDetectionStage $malfunctionDetectionStage): bool
    {
        return $user->role !== User::GUEST_ROLE;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param MalfunctionDetectionStage $malfunctionDetectionStage
     * @return bool
     */
    public function update(User $user, MalfunctionDetectionStage $malfunctionDetectionStage): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param MalfunctionDetectionStage $malfunctionDetectionStage
     * @return bool
     */
    public function delete(User $user, MalfunctionDetectionStage $malfunctionDetectionStage): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param MalfunctionDetectionStage $malfunctionDetectionStage
     * @return bool
     */
    public function restore(User $user, MalfunctionDetectionStage $malfunctionDetectionStage): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param MalfunctionDetectionStage $malfunctionDetectionStage
     * @return bool
     */
    public function forceDelete(User $user, MalfunctionDetectionStage $malfunctionDetectionStage): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }
}
