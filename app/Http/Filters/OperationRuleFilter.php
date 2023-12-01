<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class OperationRuleFilter extends AbstractFilter
{
    public const TYPE = 'type';
    public const PRIORITY = 'priority';
    public const REPEAT_VOICE = 'repeat_voice';
    public const CONTEXT = 'context';
    public const RULE_BASED_KNOWLEDGE_BASE_ID = 'rule_based_knowledge_base_id';
    public const OPERATION_ID_IF = 'operation_id_if';
    public const OPERATION_STATUS_IF = 'operation_status_if';
    public const OPERATION_RESULT_ID_IF = 'operation_result_id_if';
    public const OPERATION_ID_THEN = 'operation_id_then';
    public const OPERATION_STATUS_THEN = 'operation_status_then';
    public const OPERATION_RESULT_ID_THEN = 'operation_result_id_then';
    public const MALFUNCTION_CAUSE_ID = 'malfunction_cause_id';
    public const MALFUNCTION_SYSTEM_ID = 'malfunction_system_id';
    public const DOCUMENT_ID = 'document_id';

    protected function getCallbacks(): array
    {
        return [
            self::TYPE => [$this, 'type'],
            self::PRIORITY => [$this, 'priority'],
            self::REPEAT_VOICE => [$this, 'repeatVoice'],
            self::CONTEXT => [$this, 'context'],
            self::RULE_BASED_KNOWLEDGE_BASE_ID => [$this, 'ruleBasedKnowledgeBaseId'],
            self::OPERATION_ID_IF => [$this, 'operationIdIf'],
            self::OPERATION_STATUS_IF => [$this, 'operationStatusIf'],
            self::OPERATION_RESULT_ID_IF => [$this, 'operationResultIdIf'],
            self::OPERATION_ID_THEN => [$this, 'operationIdThen'],
            self::OPERATION_STATUS_THEN => [$this, 'operationStatusThen'],
            self::OPERATION_RESULT_ID_THEN => [$this, 'operationResultIdThen'],
            self::MALFUNCTION_CAUSE_ID => [$this, 'malfunctionCauseId'],
            self::MALFUNCTION_SYSTEM_ID => [$this, 'malfunctionSystemId'],
            self::DOCUMENT_ID => [$this, 'documentId'],
        ];
    }

    public function type(Builder $builder, $value)
    {
        $builder->where(self::TYPE, $value);
    }

    public function priority(Builder $builder, $value)
    {
        $builder->where(self::PRIORITY, $value);
    }

    public function repeatVoice(Builder $builder, $value)
    {
        $builder->where(self::REPEAT_VOICE, $value);
    }

    public function context(Builder $builder, $value)
    {
        $builder->where(self::CONTEXT, $value);
    }

    public function ruleBasedKnowledgeBaseId(Builder $builder, $value)
    {
        $builder->where(self::RULE_BASED_KNOWLEDGE_BASE_ID, $value);
    }

    public function operationIdIf(Builder $builder, $value)
    {
        $builder->where(self::OPERATION_ID_IF, $value);
    }

    public function operationStatusIf(Builder $builder, $value)
    {
        $builder->where(self::OPERATION_STATUS_IF, $value);
    }

    public function operationResultIdIf(Builder $builder, $value)
    {
        $builder->where(self::OPERATION_RESULT_ID_IF, $value);
    }

    public function operationIdThen(Builder $builder, $value)
    {
        $builder->where(self::OPERATION_ID_THEN, $value);
    }

    public function operationStatusThen(Builder $builder, $value)
    {
        $builder->where(self::OPERATION_STATUS_THEN, $value);
    }

    public function operationResultIdThen(Builder $builder, $value)
    {
        $builder->where(self::OPERATION_RESULT_ID_THEN, $value);
    }

    public function malfunctionCauseId(Builder $builder, $value)
    {
        $builder->where(self::MALFUNCTION_CAUSE_ID, $value);
    }

    public function malfunctionSystemId(Builder $builder, $value)
    {
        $builder->where(self::MALFUNCTION_SYSTEM_ID, $value);
    }

    public function documentId(Builder $builder, $value)
    {
        $builder->where(self::DOCUMENT_ID, $value);
    }
}
