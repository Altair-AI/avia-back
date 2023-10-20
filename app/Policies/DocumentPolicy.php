<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DocumentPolicy
{
    /**
     * Check actions for administrators.
     *
     * @param User $user
     * @param Document $document
     * @return bool
     */
    private function check(User $user, Document $document): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE) {
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
     * @param Document $document
     * @return Response
     */
    public function view(User $user, Document $document): Response
    {
        return $this->check($user, $document)
            ? Response::allow()
            : Response::deny('You cannot view this document.');
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
     * @param Document $document
     * @return bool
     */
    public function update(User $user, Document $document): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Document $document
     * @return bool
     */
    public function delete(User $user, Document $document): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Document $document
     * @return bool
     */
    public function restore(User $user, Document $document): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Document $document
     * @return bool
     */
    public function forceDelete(User $user, Document $document): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }
}
