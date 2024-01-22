<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class MalfunctionCodeFilter extends AbstractFilter
{
    public const NAME = 'name';
    public const TYPE = 'type';
    public const SOURCE = 'source';
    public const ALTERNATIVE_NAME = 'alternative_name';
    public const TECHNICAL_SYSTEM_ID = 'technical_system_id';

    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::TYPE => [$this, 'type'],
            self::SOURCE => [$this, 'source'],
            self::ALTERNATIVE_NAME => [$this, 'alternativeName'],
            self::TECHNICAL_SYSTEM_ID => [$this, 'technicalSystemId'],
        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where(self::NAME, 'like', "%{$value}%");
    }

    public function type(Builder $builder, $value)
    {
        $builder->where(self::TYPE, $value);
    }

    public function source(Builder $builder, $value)
    {
        $builder->where(self::SOURCE, 'like', "%{$value}%");
    }

    public function alternativeName(Builder $builder, $value)
    {
        $builder->where(self::ALTERNATIVE_NAME, 'like', "%{$value}%");
    }

    public function technicalSystemId(Builder $builder, $value)
    {
        $builder->where(self::TECHNICAL_SYSTEM_ID, $value);
    }
}
