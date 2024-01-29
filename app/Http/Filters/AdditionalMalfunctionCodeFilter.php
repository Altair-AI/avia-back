<?php

namespace App\Http\Filters;

use App\Components\Helper;
use App\Models\TechnicalSystem;
use Illuminate\Database\Eloquent\Builder;

class AdditionalMalfunctionCodeFilter extends AbstractFilter
{
    public const TYPE = 'type';
    public const TECHNICAL_SYSTEM_ID = 'technical_system_id';

    protected function getCallbacks(): array
    {
        return [
            self::TYPE => [$this, 'type'],
            self::TECHNICAL_SYSTEM_ID => [$this, 'technicalSystemId']
        ];
    }

    public function type(Builder $builder, $value)
    {
        $builder->where(self::TYPE, $value);
    }

    public function technicalSystemId(Builder $builder, $value)
    {
        // Формирование вложенного массива (иерархии) технических систем
        $technical_systems = [];
        $technical_system = TechnicalSystem::find($value);
        $model = $technical_system->toArray();
        $model['technical_subsystems'] = $technical_system->technical_subsystems;
        array_push($technical_systems, $model);
        // Получение списка id для всех дочерних технических систем или объектов (если они есть)
        $tech_sys_ids = Helper::get_technical_system_ids($technical_systems, []);
        // Фильтрация
        $builder->whereIn(self::TECHNICAL_SYSTEM_ID, $tech_sys_ids);
    }
}
