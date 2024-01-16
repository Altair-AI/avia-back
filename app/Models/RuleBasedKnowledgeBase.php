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
 * @property-read Project $projects
 * @property-read TechnicalSystem $technical_system
 * @property-read User $user
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

    // Статусы доступности продукционных баз знаний
    const PUBLIC_STATUS = 0;  // Открытая (доступна для просмотра всем пользователям)
    const PRIVATE_STATUS = 1; // Закрытая (доступна только внутри определенного проекта)

    // Статусы правильности продукционных баз знаний
    const CORRECT_TYPE = 0;   // Корректная база знаний (проверена экспертом и может быть использована техниками)
    const INCORRECT_TYPE = 1; // Некорректная база знаний (не проверена экспертом и не может использоваться техниками)

    protected $hidden = ['pivot'];

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

    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function technical_system()
    {
        return $this->belongsTo(TechnicalSystem::class);
    }

    public function rule_based_knowledge_base_projects()
    {
        return $this->hasMany(RuleBasedKnowledgeBaseProject::class, 'rule_based_knowledge_base_id');
    }

    /**
     * Получить все проекты в которых используется данная база знаний с правилами.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'rule_based_knowledge_base_project',
            'rule_based_knowledge_base_id', 'project_id');
    }

    public function malfunction_cause_rules()
    {
        return $this->hasMany(MalfunctionCauseRule::class, 'rule_based_knowledge_base_id');
    }

    public function operation_rules()
    {
        return $this->hasMany(OperationRule::class, 'rule_based_knowledge_base_id');
    }
}
