<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\RuleBasedKnowledgeBase;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RuleBasedKnowledgeBasePolicy
{
    /**
     * Check actions for administrators.
     *
     * @param User $user
     * @param RuleBasedKnowledgeBase $ruleBasedKnowledgeBase
     * @return bool
     */
    private function check(User $user, RuleBasedKnowledgeBase $ruleBasedKnowledgeBase): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE)
            foreach (Organization::find($user->organization_id)->projects as $project)
                if ($ruleBasedKnowledgeBase->id == RuleBasedKnowledgeBase::find($project->technical_system_id)->id)
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
     * @param RuleBasedKnowledgeBase $ruleBasedKnowledgeBase
     * @return Response
     */
    public function view(User $user, RuleBasedKnowledgeBase $ruleBasedKnowledgeBase): Response
    {
        return $this->check($user, $ruleBasedKnowledgeBase)
            ? Response::allow()
            : Response::deny('You cannot view this rule based knowledge base.');
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
     * @param RuleBasedKnowledgeBase $ruleBasedKnowledgeBase
     * @return bool
     */
    public function update(User $user, RuleBasedKnowledgeBase $ruleBasedKnowledgeBase): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param RuleBasedKnowledgeBase $ruleBasedKnowledgeBase
     * @return bool
     */
    public function delete(User $user, RuleBasedKnowledgeBase $ruleBasedKnowledgeBase): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param RuleBasedKnowledgeBase $ruleBasedKnowledgeBase
     * @return bool
     */
    public function restore(User $user, RuleBasedKnowledgeBase $ruleBasedKnowledgeBase): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param RuleBasedKnowledgeBase $ruleBasedKnowledgeBase
     * @return bool
     */
    public function forceDelete(User $user, RuleBasedKnowledgeBase $ruleBasedKnowledgeBase): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }
}
