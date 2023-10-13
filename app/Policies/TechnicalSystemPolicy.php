<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\TechnicalSystem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TechnicalSystemPolicy
{
    /**
     * Получение списка id для всех дочерних технических систем или объектов (если они есть).
     *
     * @param $technical_systems
     * @param $id_list
     * @return mixed
     */
    private static function get_technical_system_ids($technical_systems, $id_list)
    {
        foreach ($technical_systems as $item) {
            array_push($id_list, $item['id']);
            if (!empty($item['grandchildren_technical_systems']))
                $id_list = self::get_technical_system_ids($item['grandchildren_technical_systems'], $id_list);
        }
        return $id_list;
    }

    /**
     * Check actions for administrators.
     *
     * @param User $user
     * @param TechnicalSystem $technical_system
     * @return bool
     */
    private function check(User $user, TechnicalSystem $technical_system): bool
    {
        if ($user->role === User::SUPER_ADMIN_ROLE)
            return true;
        if ($user->role === User::ADMIN_ROLE) {
            // Формирование вложенного массива (иерархии) технических систем
            $technical_systems = [];
            foreach (Organization::find($user->organization->id)->licenses as $license) {
                $model = $license->project->technical_system->toArray();
                $model['grandchildren_technical_systems'] = TechnicalSystem::find(
                    $license->project->technical_system_id)->grandchildren_technical_systems;
                array_push($technical_systems, $model);
            }
            // Получение id всех технических систем или объектов для вложенного массива (иерархии) технических систем
            $technical_system_ids = self::get_technical_system_ids($technical_systems, []);
            // Поиск совпадения идентификаторов
            foreach ($technical_system_ids as $id)
                if ($technical_system->id == $id)
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
     * @param TechnicalSystem $technical_system
     * @return Response
     */
    public function view(User $user, TechnicalSystem $technical_system): Response
    {
        return $this->check($user, $technical_system)
            ? Response::allow()
            : Response::deny('You cannot view this technical system.');
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
     * @param TechnicalSystem $technical_system
     * @return bool
     */
    public function update(User $user, TechnicalSystem $technical_system): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param TechnicalSystem $technical_system
     * @return bool
     */
    public function delete(User $user, TechnicalSystem $technical_system): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param TechnicalSystem $technical_system
     * @return bool
     */
    public function restore(User $user, TechnicalSystem $technical_system): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param TechnicalSystem $technical_system
     * @return bool
     */
    public function forceDelete(User $user, TechnicalSystem $technical_system): bool
    {
        return $user->role === User::SUPER_ADMIN_ROLE;
    }
}
