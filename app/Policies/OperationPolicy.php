<?php

namespace App\Policies;

use App\Components\Helper;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OperationPolicy
{
    /**
     * Check actions for administrators.
     *
     * @param User $user
     * @param Operation $operation
     * @return bool
     */
    private function check(User $user, Operation $operation): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE) {
            // Формирование вложенного массива (иерархии) технических систем доступных администратору
            $technical_systems = Helper::get_technical_system_hierarchy($user->organization->id);
            // Получение всех кодов технических систем или объектов для вложенного массива (иерархии) технических систем
            $technical_system_codes = Helper::get_technical_system_codes($technical_systems, []);
            // Поиск совпадения кодов технических систем
            foreach ($technical_system_codes as $technical_system_code)
                foreach ($operation->technical_systems as $technical_system)
                    if ($technical_system->code == $technical_system_code)
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
     * @param Operation $operation
     * @return Response
     */
    public function view(User $user, Operation $operation): Response
    {
        return $this->check($user, $operation)
            ? Response::allow()
            : Response::deny('You cannot view this operation.');
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
     * @param Operation $operation
     * @return bool
     */
    public function update(User $user, Operation $operation): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Operation $operation
     * @return bool
     */
    public function delete(User $user, Operation $operation): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Operation $operation
     * @return bool
     */
    public function restore(User $user, Operation $operation): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Operation $operation
     * @return bool
     */
    public function forceDelete(User $user, Operation $operation): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }
}
