<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrganizationPolicy
{
    /**
     * Check actions for administrators.
     *
     * @param User $user
     * @param Organization $organization
     * @return bool
     */
    private function check(User $user, Organization $organization): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE and $user->organization_id === $organization->id)
            return true;
        return false;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Organization $organization
     * @return Response
     */
    public function view(User $user, Organization $organization): Response
    {
        return $this->check($user, $organization)
            ? Response::allow()
            : Response::deny('You cannot view this organization.');
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
     * @param Organization $organization
     * @return bool
     */
    public function update(User $user, Organization $organization): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Organization $organization
     * @return bool
     */
    public function delete(User $user, Organization $organization): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Organization $organization
     * @return bool
     */
    public function restore(User $user, Organization $organization): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Organization $organization
     * @return bool
     */
    public function forceDelete(User $user, Organization $organization): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }
}
