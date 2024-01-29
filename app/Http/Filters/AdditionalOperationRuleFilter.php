<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class AdditionalOperationRuleFilter extends AbstractFilter
{
    public const MALFUNCTION_SYSTEM_ID = 'malfunction_system_id';

    protected function getCallbacks(): array
    {
        return [
            self::MALFUNCTION_SYSTEM_ID => [$this, 'malfunctionSystemId']
        ];
    }

    public function malfunctionSystemId(Builder $builder, $value)
    {
        $builder->where(self::MALFUNCTION_SYSTEM_ID, $value);
    }
}
