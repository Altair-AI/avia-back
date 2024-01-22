<?php

namespace App\Policies;

use App\Components\Helper;
use App\Models\MalfunctionCode;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MalfunctionCodePolicy
{
    /**
     * Check actions for administrators.
     *
     * @param User $user
     * @param MalfunctionCode $malfunctionCode
     * @return bool
     */
    private function check(User $user, MalfunctionCode $malfunctionCode): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE or $user->role === User::TECHNICIAN_ROLE) {
            // Формирование вложенного массива (иерархии) технических систем доступных администратору и технику
            $technical_systems = Helper::get_technical_system_hierarchy($user->organization_id);
            // Получение id всех технических систем или объектов для вложенного массива (иерархии) технических систем
            $technical_system_ids = Helper::get_technical_system_ids($technical_systems, []);
            // Поиск совпадения идентификаторов
            foreach ($technical_system_ids as $technical_system_id)
                if ($malfunctionCode->technical_system_id == $technical_system_id)
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
     * @param MalfunctionCode $malfunctionCode
     * @return Response
     */
    public function view(User $user, MalfunctionCode $malfunctionCode): Response
    {
        return $this->check($user, $malfunctionCode)
            ? Response::allow()
            : Response::deny('You cannot view this malfunction code.');
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
     * @param MalfunctionCode $malfunctionCode
     * @return bool
     */
    public function update(User $user, MalfunctionCode $malfunctionCode): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param MalfunctionCode $malfunctionCode
     * @return bool
     */
    public function delete(User $user, MalfunctionCode $malfunctionCode): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param MalfunctionCode $malfunctionCode
     * @return bool
     */
    public function restore(User $user, MalfunctionCode $malfunctionCode): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param MalfunctionCode $malfunctionCode
     * @return bool
     */
    public function forceDelete(User $user, MalfunctionCode $malfunctionCode): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }
}
