<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MalfunctionCauseRule extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_cause_rule';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'description',
        'cause',
        'document_id',
        'rule_based_knowledge_base_id',
    ];

    public function document()
    {
        return $this->belongsTo('app\Models\Document');
    }

    public function rule_based_knowledge_base()
    {
        return $this->belongsTo('app\Models\RuleBasedKnowledgeBase');
    }

    public function malfunction_cause_rules_if()
    {
        return $this->hasMany('app\Models\MalfunctionCauseRuleIf', 'malfunction_cause_rule_id');
    }

    public function malfunction_cause_rules_then()
    {
        return $this->hasMany('app\Models\MalfunctionCauseRuleThen', 'malfunction_cause_rule_id');
    }
}
