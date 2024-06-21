<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CaseFilter extends AbstractFilter
{
    public const DATE = 'date';
    public const CARD_NUMBER = 'card_number';
    public const OPERATION_TIME_FROM_START = 'operation_time_from_start';
    public const OPERATION_TIME_FROM_LAST_REPAIR = 'operation_time_from_last_repair';
    public const MALFUNCTION_DETECTION_STAGE_ID = 'malfunction_detection_stage_id';
    public const MALFUNCTION_CAUSE_ID = 'malfunction_cause_id';
    public const SYSTEM_ID_FOR_REPAIR = 'system_id_for_repair';
    public const INITIAL_COMPLETED_OPERATION_ID = 'initial_completed_operation_id';
    public const CASE_BASED_KNOWLEDGE_BASE_ID = 'case_based_knowledge_base_id';

    protected function getCallbacks(): array
    {
        return [
            self::DATE => [$this, 'date'],
            self::CARD_NUMBER => [$this, 'cardNumber'],
            self::OPERATION_TIME_FROM_START => [$this, 'operationTimeFromStart'],
            self::OPERATION_TIME_FROM_LAST_REPAIR => [$this, 'operationTimeFromLastRepair'],
            self::MALFUNCTION_DETECTION_STAGE_ID => [$this, 'malfunctionDetectionStageId'],
            self::MALFUNCTION_CAUSE_ID => [$this, 'malfunctionCauseId'],
            self::SYSTEM_ID_FOR_REPAIR => [$this, 'systemIdForRepair'],
            self::INITIAL_COMPLETED_OPERATION_ID => [$this, 'initialCompletedOperationId'],
            self::CASE_BASED_KNOWLEDGE_BASE_ID => [$this, 'caseBasedKnowledgeBaseId']
        ];
    }

    public function date(Builder $builder, $value)
    {
        $builder->where(self::DATE, $value);
    }

    public function cardNumber(Builder $builder, $value)
    {
        $builder->where(self::CARD_NUMBER, $value);
    }

    public function operationTimeFromStart(Builder $builder, $value)
    {
        $builder->where(self::OPERATION_TIME_FROM_START, $value);
    }

    public function operationTimeFromLastRepair(Builder $builder, $value)
    {
        $builder->where(self::OPERATION_TIME_FROM_LAST_REPAIR, $value);
    }

    public function malfunctionDetectionStageId(Builder $builder, $value)
    {
        $builder->where(self::MALFUNCTION_DETECTION_STAGE_ID, $value);
    }

    public function malfunctionCauseId(Builder $builder, $value)
    {
        $builder->where(self::MALFUNCTION_CAUSE_ID, $value);
    }

    public function systemIdForRepair(Builder $builder, $value)
    {
        $builder->where(self::SYSTEM_ID_FOR_REPAIR, $value);
    }

    public function initialCompletedOperationId(Builder $builder, $value)
    {
        $builder->where(self::INITIAL_COMPLETED_OPERATION_ID, $value);
    }

    public function caseBasedKnowledgeBaseId(Builder $builder, $value)
    {
        $builder->where(self::CASE_BASED_KNOWLEDGE_BASE_ID, $value);
    }
}
