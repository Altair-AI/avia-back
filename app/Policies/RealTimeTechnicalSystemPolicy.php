<?php

namespace App\Policies;

use App\Models\RealTimeTechnicalSystem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RealTimeTechnicalSystemPolicy
{
    /**
     * Check actions for all users.
     *
     * @param User $user
     * @param RealTimeTechnicalSystem $real_time_technical_system
     * @return bool
     */
    private function common_check(User $user, RealTimeTechnicalSystem $real_time_technical_system): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE)
            foreach ($user->organization->projects as $project)
                if ($project->id == $real_time_technical_system->project_id)
                    return true;
        if ($user->role === User::TECHNICIAN_ROLE)
            foreach ($real_time_technical_system->users as $tech_sys_user)
                if ($tech_sys_user->id == $user->id)
                    return true;
        return false;
    }

    /**
     * Check actions for administrators.
     *
     * @param User $user
     * @param RealTimeTechnicalSystem $real_time_technical_system
     * @return bool
     */
    private function admin_check(User $user, RealTimeTechnicalSystem $real_time_technical_system): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE)
            foreach ($user->organization->projects as $project)
                if ($project->id == $real_time_technical_system->project_id)
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
        return $user->role === User::SUPER_ADMIN_ROLE or $user->role === User::ADMIN_ROLE or
            $user->role === User::TECHNICIAN_ROLE;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param RealTimeTechnicalSystem $realTimeTechnicalSystem
     * @return Response
     */
    public function view(User $user, RealTimeTechnicalSystem $realTimeTechnicalSystem): Response
    {
        return $this->common_check($user, $realTimeTechnicalSystem)
            ? Response::allow()
            : Response::deny('You cannot view this real time technical system.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE or $user->role === User::ADMIN_ROLE;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param RealTimeTechnicalSystem $realTimeTechnicalSystem
     * @return Response
     */
    public function update(User $user, RealTimeTechnicalSystem $realTimeTechnicalSystem): Response
    {
        return $this->admin_check($user, $realTimeTechnicalSystem)
            ? Response::allow()
            : Response::deny('You cannot update this real time technical system.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param RealTimeTechnicalSystem $realTimeTechnicalSystem
     * @return Response
     */
    public function delete(User $user, RealTimeTechnicalSystem $realTimeTechnicalSystem): Response
    {
        return $this->admin_check($user, $realTimeTechnicalSystem)
            ? Response::allow()
            : Response::deny('You cannot delete this real time technical system.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param RealTimeTechnicalSystem $realTimeTechnicalSystem
     * @return Response
     */
    public function restore(User $user, RealTimeTechnicalSystem $realTimeTechnicalSystem): Response
    {
        return $this->admin_check($user, $realTimeTechnicalSystem)
            ? Response::allow()
            : Response::deny('You cannot restore this real time technical system.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param RealTimeTechnicalSystem $realTimeTechnicalSystem
     * @return Response
     */
    public function forceDelete(User $user, RealTimeTechnicalSystem $realTimeTechnicalSystem): Response
    {
        return $this->admin_check($user, $realTimeTechnicalSystem)
            ? Response::allow()
            : Response::deny('You cannot permanently delete this real time technical system.');
    }
}
