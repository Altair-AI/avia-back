<?php

namespace App\Http\Filters;

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
        $builder->where(self::TECHNICAL_SYSTEM_ID, $value);
    }
}
