<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class WorkSessionFilter extends AbstractFilter
{
    public const STATUS = 'status';
    public const STOP_TIME = 'stop_time';
    public const MALFUNCTION_CAUSE_RULE_ID = 'malfunction_cause_rule_id';
    public const USER_ID = 'user_id';

    protected function getCallbacks(): array
    {
        return [
            self::STATUS => [$this, 'status'],
            self::STOP_TIME => [$this, 'stopTime'],
            self::MALFUNCTION_CAUSE_RULE_ID => [$this, 'malfunctionCauseRuleId'],
            self::USER_ID => [$this, 'userId'],
        ];
    }

    public function status(Builder $builder, $value)
    {
        $builder->where(self::STATUS, $value);
    }

    public function stopTime(Builder $builder, $value)
    {
        $builder->where(self::STOP_TIME, $value);
    }

    public function malfunctionCauseRuleId(Builder $builder, $value)
    {
        $builder->where(self::MALFUNCTION_CAUSE_RULE_ID, $value);
    }

    public function userId(Builder $builder, $value)
    {
        $builder->where(self::USER_ID, $value);
    }
}
