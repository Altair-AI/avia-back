<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Check actions for administrators.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    private function check(User $user, Project $project): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE)
            foreach (Organization::find($user->organization->id)->licenses as $license)
                if ($license->project_id == $project->id)
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
        return $user->role === User::SUPER_ADMIN_ROLE or $user->role === User::ADMIN_ROLE;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Project $project
     * @return Response
     */
    public function view(User $user, Project $project): Response
    {
        return $this->check($user, $project)
            ? Response::allow()
            : Response::deny('You do not own this project.');
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
     * @param Project $project
     * @return Response
     */
    public function update(User $user, Project $project): Response
    {
        return $this->check($user, $project)
            ? Response::allow()
            : Response::deny('You do not own this project.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function restore(User $user, Project $project): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }
}
