<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class MalfunctionCauseRuleFilter extends AbstractFilter
{
    public const CAUSE = 'cause';
    public const DOCUMENT_ID = 'document_id';
    public const RULE_BASED_KNOWLEDGE_BASE_ID = 'rule_based_knowledge_base_id';

    protected function getCallbacks(): array
    {
        return [
            self::CAUSE => [$this, 'cause'],
            self::DOCUMENT_ID => [$this, 'documentId'],
            self::RULE_BASED_KNOWLEDGE_BASE_ID => [$this, 'ruleBasedKnowledgeBaseId'],
        ];
    }

    public function cause(Builder $builder, $value)
    {
        $builder->where(self::CAUSE, 'like', "%{$value}%");
    }

    public function documentId(Builder $builder, $value)
    {
        $builder->where(self::DOCUMENT_ID, $value);
    }

    public function ruleBasedKnowledgeBaseId(Builder $builder, $value)
    {
        $builder->where(self::RULE_BASED_KNOWLEDGE_BASE_ID, $value);
    }
}
