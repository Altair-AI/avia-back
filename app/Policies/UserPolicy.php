<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Check actions for administrators.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    private function check(User $user, User $model): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE and $user->organization_id === $model->organization_id)
            if ($model->role === User::ADMIN_ROLE or $model->role === User::TECHNICIAN_ROLE)
                return true;
        return false;
    }

    /**
     * Determine whether the user can view any models.
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE or $user->role === User::ADMIN_ROLE;
    }

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @param User $model
     * @return Response
     */
    public function view(User $user, User $model): Response
    {
        return $this->check($user, $model)
            ? Response::allow()
            : Response::deny('Actions on this user are not available to you.');
    }

    /**
     * Determine whether the user can create models.
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE or $user->role === User::ADMIN_ROLE;
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param User $model
     * @return Response
     */
    public function update(User $user, User $model): Response
    {
        return $this->check($user, $model)
            ? Response::allow()
            : Response::deny('Actions on this user are not available to you.');
    }

    /**
     * Determine whether the user can delete the model.
     * @param User $user
     * @param User $model
     * @return Response
     */
    public function delete(User $user, User $model): Response
    {
        return $this->check($user, $model)
            ? Response::allow()
            : Response::deny('Actions on this user are not available to you.');
    }

    /**
     * Determine whether the user can restore the model.
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function restore(User $user, User $model): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }
}
