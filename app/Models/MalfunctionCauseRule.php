<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MalfunctionCauseRule
 *
 * @property int $id
 * @property string|null $description
 * @property string $cause
 * @property int $document_id
 * @property int $rule_based_knowledge_base_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Document $document
 * @method static Builder|MalfunctionCauseRule newModelQuery()
 * @method static Builder|MalfunctionCauseRule newQuery()
 * @method static Builder|MalfunctionCauseRule query()
 * @method static Builder|MalfunctionCauseRule whereCause($value)
 * @method static Builder|MalfunctionCauseRule whereCreatedAt($value)
 * @method static Builder|MalfunctionCauseRule whereDescription($value)
 * @method static Builder|MalfunctionCauseRule whereDocumentId($value)
 * @method static Builder|MalfunctionCauseRule whereId($value)
 * @method static Builder|MalfunctionCauseRule whereRuleBasedKnowledgeBaseId($value)
 * @method static Builder|MalfunctionCauseRule whereUpdatedAt($value)
 * @mixin Builder
 */
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
