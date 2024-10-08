<?php

namespace App\Policies;

use App\Models\MalfunctionCauseRule;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MalfunctionCauseRulePolicy
{
    /**
     * Check actions for administrators.
     *
     * @param User $user
     * @param MalfunctionCauseRule $malfunctionCauseRule
     * @return bool
     */
    private function check(User $user, MalfunctionCauseRule $malfunctionCauseRule): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE)
            foreach (Organization::find($user->organization->id)->projects as $proj)
                if ($proj->technical_system_id == $malfunctionCauseRule->rule_based_knowledge_base->technical_system_id)
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
     * @param MalfunctionCauseRule $malfunctionCauseRule
     * @return Response
     */
    public function view(User $user, MalfunctionCauseRule $malfunctionCauseRule): Response
    {
        return $this->check($user, $malfunctionCauseRule)
            ? Response::allow()
            : Response::deny('You cannot view this malfunction cause rule.');
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
     * @param MalfunctionCauseRule $malfunctionCauseRule
     * @return bool
     */
    public function update(User $user, MalfunctionCauseRule $malfunctionCauseRule): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param MalfunctionCauseRule $malfunctionCauseRule
     * @return bool
     */
    public function delete(User $user, MalfunctionCauseRule $malfunctionCauseRule): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param MalfunctionCauseRule $malfunctionCauseRule
     * @return bool
     */
    public function restore(User $user, MalfunctionCauseRule $malfunctionCauseRule): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param MalfunctionCauseRule $malfunctionCauseRule
     * @return bool
     */
    public function forceDelete(User $user, MalfunctionCauseRule $malfunctionCauseRule): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }
}
