<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\RuleBasedKnowledgeBase
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $status
 * @property int $correctness
 * @property int $author
 * @property int $technical_system_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, MalfunctionCauseRule> $malfunction_cause_rules
 * @property-read int|null $malfunction_cause_rules_count
 * @property-read Collection<int, OperationRule> $operation_rules
 * @property-read int|null $operation_rules_count
 * @method static Builder|RuleBasedKnowledgeBase newModelQuery()
 * @method static Builder|RuleBasedKnowledgeBase newQuery()
 * @method static Builder|RuleBasedKnowledgeBase query()
 * @method static Builder|RuleBasedKnowledgeBase whereAuthor($value)
 * @method static Builder|RuleBasedKnowledgeBase whereCorrectness($value)
 * @method static Builder|RuleBasedKnowledgeBase whereCreatedAt($value)
 * @method static Builder|RuleBasedKnowledgeBase whereDescription($value)
 * @method static Builder|RuleBasedKnowledgeBase whereId($value)
 * @method static Builder|RuleBasedKnowledgeBase whereName($value)
 * @method static Builder|RuleBasedKnowledgeBase whereStatus($value)
 * @method static Builder|RuleBasedKnowledgeBase whereTechnicalSystemId($value)
 * @method static Builder|RuleBasedKnowledgeBase whereUpdatedAt($value)
 * @mixin Builder
 */
class RuleBasedKnowledgeBase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rule_based_knowledge_base';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'correctness',
        'author',
        'technical_system_id',
    ];

    public function author()
    {
        return $this->belongsTo('app\Models\User');
    }

    public function technical_system()
    {
        return $this->belongsTo('app\Models\TechnicalSystem');
    }

    public function rule_based_knowledge_base_projects()
    {
        return $this->hasMany('app\Models\RuleBasedKnowledgeBaseProject', 'rule_based_knowledge_base_id');
    }

    public function malfunction_cause_rules()
    {
        return $this->hasMany('app\Models\MalfunctionCauseRule', 'rule_based_knowledge_base_id');
    }

    public function operation_rules()
    {
        return $this->hasMany('app\Models\OperationRule', 'rule_based_knowledge_base_id');
    }
}
