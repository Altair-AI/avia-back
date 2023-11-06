<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class TechnicalSystemFilter extends AbstractFilter
{
    public const CODE = 'code';
    public const NAME = 'name';
    public const PARENT_TECHNICAL_SYSTEM_ID = 'parent_technical_system_id';

    protected function getCallbacks(): array
    {
        return [
            self::CODE => [$this, 'code'],
            self::NAME => [$this, 'name'],
            self::PARENT_TECHNICAL_SYSTEM_ID => [$this, 'parentTechnicalSystemId'],
        ];
    }

    public function code(Builder $builder, $value)
    {
        $builder->where(self::CODE, $value);
    }

    public function name(Builder $builder, $value)
    {
        $builder->where(self::NAME, 'like', "%{$value}%");
    }

    public function parentTechnicalSystemId(Builder $builder, $value)
    {
        $builder->where(self::PARENT_TECHNICAL_SYSTEM_ID, $value);
    }
}
