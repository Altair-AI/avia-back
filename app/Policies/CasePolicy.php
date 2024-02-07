<?php

namespace App\Policies;

use App\Models\CaseBasedKnowledgeBase;
use App\Models\ECase;
use App\Models\RealTimeTechnicalSystemUser;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CasePolicy
{
    /**
     * Check actions for all users.
     *
     * @param User $user
     * @param ECase $case
     * @return bool
     */
    private function check(User $user, ECase $case): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE) {
            $project_ids = [];
            foreach ($user->organization->projects as $project)
                array_push($project_ids, $project->id);
            $case_based_kb_ids = CaseBasedKnowledgeBase::select('id')
                ->whereIn('project_id', $project_ids)->get();
            foreach ($case_based_kb_ids as $case_based_kb_id)
                if ($case_based_kb_id == $case->case_based_knowledge_base_id)
                    return true;
        }
        if ($user->role === User::TECHNICIAN_ROLE) {
            $real_time_tech_system_ids = RealTimeTechnicalSystemUser::select('real_time_technical_system_id')
                ->where('user_id', $user->id)
                ->get();
            $case_based_kb_ids = CaseBasedKnowledgeBase::select('id')
                ->whereIn('real_time_technical_system_id', $real_time_tech_system_ids)->get();
            foreach ($case_based_kb_ids as $case_based_kb_id)
                if ($case_based_kb_id == $case->case_based_knowledge_base_id)
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
        return $user->role !== User::GUEST_ROLE;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param ECase $case
     * @return Response
     */
    public function view(User $user, ECase $case): Response
    {
        return $this->check($user, $case)
            ? Response::allow()
            : Response::deny('You cannot view this case.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->role !== User::GUEST_ROLE;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param ECase $case
     * @return Response
     */
    public function update(User $user, ECase $case): Response
    {
        return $this->check($user, $case)
            ? Response::allow()
            : Response::deny('You cannot update this case.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param ECase $case
     * @return Response
     */
    public function delete(User $user, ECase $case): Response
    {
        return $this->check($user, $case)
            ? Response::allow()
            : Response::deny('You cannot delete this case.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param ECase $case
     * @return Response
     */
    public function restore(User $user, ECase $case): Response
    {
        return $this->check($user, $case)
            ? Response::allow()
            : Response::deny('You cannot restore this case.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param ECase $case
     * @return Response
     */
    public function forceDelete(User $user, ECase $case): Response
    {
        return $this->check($user, $case)
            ? Response::allow()
            : Response::deny('You cannot force delete this case.');
    }
}
