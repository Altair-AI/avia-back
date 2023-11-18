<?php

namespace App\Policies;

use App\Models\OperationRule;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OperationRulePolicy
{
    /**
     * Check actions for administrators.
     *
     * @param User $user
     * @param OperationRule $operationRule
     * @return bool
     */
    private function check(User $user, OperationRule $operationRule): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE)
            foreach (Organization::find($user->organization->id)->projects as $proj)
                if ($proj->technical_system_id == $operationRule->rule_based_knowledge_base->technical_system_id)
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
     * @param OperationRule $operationRule
     * @return Response
     */
    public function view(User $user, OperationRule $operationRule): Response
    {
        return $this->check($user, $operationRule)
            ? Response::allow()
            : Response::deny('You cannot view this operation rule.');
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
     * @param OperationRule $operationRule
     * @return bool
     */
    public function update(User $user, OperationRule $operationRule): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param OperationRule $operationRule
     * @return bool
     */
    public function delete(User $user, OperationRule $operationRule): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param OperationRule $operationRule
     * @return bool
     */
    public function restore(User $user, OperationRule $operationRule): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param OperationRule $operationRule
     * @return bool
     */
    public function forceDelete(User $user, OperationRule $operationRule): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }
}
