<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkSession;
use Illuminate\Auth\Access\Response;

class WorkSessionPolicy
{
    /**
     * Check actions for administrators.
     *
     * @param User $user
     * @param WorkSession $work_session
     * @return bool
     */
    private function check(User $user, WorkSession $work_session): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE) {
            $found_users = User::whereOrganizationId($user->organization_id)->get();
            foreach ($found_users as $found_user)
                if ($work_session->user_id === $found_user->id)
                    return true;
        }
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
        return $user->role === User::SUPER_ADMIN_ROLE or $user->role === User::ADMIN_ROLE;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param WorkSession $work_session
     * @return Response
     */
    public function view(User $user, WorkSession $work_session): Response
    {
        return $this->check($user, $work_session)
            ? Response::allow()
            : Response::deny('You cannot view this work session.');
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
     * @param WorkSession $work_session
     * @return bool
     */
    public function update(User $user, WorkSession $work_session): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param WorkSession $work_session
     * @return bool
     */
    public function delete(User $user, WorkSession $work_session): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param WorkSession $work_session
     * @return bool
     */
    public function restore(User $user, WorkSession $work_session): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param WorkSession $work_session
     * @return bool
     */
    public function forceDelete(User $user, WorkSession $work_session): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }
}
