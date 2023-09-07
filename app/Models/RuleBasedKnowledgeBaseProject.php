<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\RuleBasedKnowledgeBaseProject
 *
 * @property int $id
 * @property int $rule_based_knowledge_base_id
 * @property int $project_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Project $project
 * @property-read RuleBasedKnowledgeBase $rule_based_knowledge_base
 * @method static Builder|RuleBasedKnowledgeBaseProject newModelQuery()
 * @method static Builder|RuleBasedKnowledgeBaseProject newQuery()
 * @method static Builder|RuleBasedKnowledgeBaseProject query()
 * @method static Builder|RuleBasedKnowledgeBaseProject whereCreatedAt($value)
 * @method static Builder|RuleBasedKnowledgeBaseProject whereId($value)
 * @method static Builder|RuleBasedKnowledgeBaseProject whereProjectId($value)
 * @method static Builder|RuleBasedKnowledgeBaseProject whereRuleBasedKnowledgeBaseId($value)
 * @method static Builder|RuleBasedKnowledgeBaseProject whereUpdatedAt($value)
 * @mixin Builder
 */
class RuleBasedKnowledgeBaseProject extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rule_based_knowledge_base_project';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'rule_based_knowledge_base_id',
        'project_id',
    ];

    public function rule_based_knowledge_base()
    {
        return $this->belongsTo('app\Models\RuleBasedKnowledgeBase');
    }

    public function project()
    {
        return $this->belongsTo('app\Models\Project');
    }
}
