<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class RealTimeTechnicalSystemFilter extends AbstractFilter
{
    public const REGISTRATION_CODE = 'registration_code';
    public const REGISTRATION_DESCRIPTION = 'registration_description';
    public const OPERATION_TIME_FROM_START = 'operation_time_from_start';
    public const OPERATION_TIME_FROM_LAST_REPAIR = 'operation_time_from_last_repair';
    public const TECHNICAL_SYSTEM_ID = 'technical_system_id';
    public const PROJECT_ID = 'project_id';

    protected function getCallbacks(): array
    {
        return [
            self::REGISTRATION_CODE => [$this, 'registrationCode'],
            self::REGISTRATION_DESCRIPTION => [$this, 'registrationDescription'],
            self::OPERATION_TIME_FROM_START => [$this, 'operationTimeFromStart'],
            self::OPERATION_TIME_FROM_LAST_REPAIR => [$this, 'operationTimeFromLastRepair'],
            self::TECHNICAL_SYSTEM_ID => [$this, 'technicalSystemId'],
            self::PROJECT_ID => [$this, 'projectId'],
        ];
    }

    public function registrationCode(Builder $builder, $value)
    {
        $builder->where(self::REGISTRATION_CODE, $value);
    }

    public function registrationDescription(Builder $builder, $value)
    {
        $builder->where(self::REGISTRATION_DESCRIPTION, 'like', "%{$value}%");
    }

    public function operationTimeFromStart(Builder $builder, $value)
    {
        $builder->where(self::OPERATION_TIME_FROM_START, $value);
    }

    public function operationTimeFromLastRepair(Builder $builder, $value)
    {
        $builder->where(self::OPERATION_TIME_FROM_LAST_REPAIR, $value);
    }

    public function technicalSystemId(Builder $builder, $value)
    {
        $builder->where(self::TECHNICAL_SYSTEM_ID, $value);
    }

    public function projectId(Builder $builder, $value)
    {
        $builder->where(self::PROJECT_ID, $value);
    }
}
