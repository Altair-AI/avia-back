<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\TechnicalSystem
 *
 * @property int $id
 * @property string|null $code
 * @property string $name
 * @property string|null $description
 * @property int|null $parent_technical_system_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, TechnicalSystem> $child_technical_systems
 * @property-read int|null $child_technical_systems_count
 * @property-read Collection<int, MalfunctionCauseRuleThen> $malfunction_cause_rules_then
 * @property-read int|null $malfunction_cause_rules_then_count
 * @property-read Collection<int, MalfunctionCode> $malfunction_codes
 * @property-read int|null $malfunction_codes_count
 * @property-read Collection<int, OperationRule> $operation_rules_for_cause_system
 * @property-read int|null $operation_rules_for_cause_system_count
 * @property-read Collection<int, OperationRule> $operation_rules_for_malfunction_system
 * @property-read int|null $operation_rules_for_malfunction_system_count
 * @property-read TechnicalSystem|null $parent_technical_system
 * @property-read Collection<int, Project> $projects
 * @property-read int|null $projects_count
 * @property-read Collection<int, RealTimeTechnicalSystem> $real_time_technical_systems
 * @property-read int|null $real_time_technical_systems_count
 * @property-read Collection<int, RuleBasedKnowledgeBase> $rule_based_knowledge_bases
 * @property-read int|null $rule_based_knowledge_bases_count
 * @method static Builder|TechnicalSystem newModelQuery()
 * @method static Builder|TechnicalSystem newQuery()
 * @method static Builder|TechnicalSystem query()
 * @method static Builder|TechnicalSystem whereCode($value)
 * @method static Builder|TechnicalSystem whereCreatedAt($value)
 * @method static Builder|TechnicalSystem whereDescription($value)
 * @method static Builder|TechnicalSystem whereId($value)
 * @method static Builder|TechnicalSystem whereName($value)
 * @method static Builder|TechnicalSystem whereParentTechnicalSystemId($value)
 * @method static Builder|TechnicalSystem whereUpdatedAt($value)
 * @mixin Builder
 */
class TechnicalSystem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'technical_system';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'parent_technical_system_id',
    ];

    /**
     * Возвращает родительскую систему (если она есть).
     *
     * @return BelongsTo
     */
    public function parent_technical_system()
    {
        return $this->belongsTo(self::class);
    }

    /**
     * Возвращает непосредственные дочерние системы и объекты (один уровень вложенности иерархии) для
     * текущей технической системы.
     *
     * @return HasMany
     */
    public function child_technical_systems()
    {
        return $this->hasMany(self::class, 'parent_technical_system_id');
    }

    /**
     * Возвращает всю иерархию дочерних систем и объектов для текущей технической системы.
     *
     * @return HasMany
     */
    public function grandchildren_technical_systems()
    {
        return $this->child_technical_systems()->with('grandchildren_technical_systems');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'technical_system_id');
    }

    public function real_time_technical_systems()
    {
        return $this->hasMany(RealTimeTechnicalSystem::class, 'technical_system_id');
    }

    public function technical_system_documents()
    {
        return $this->hasMany(TechnicalSystemDocument::class, 'technical_system_id');
    }

    public function technical_system_operations()
    {
        return $this->hasMany(TechnicalSystemOperation::class, 'technical_system_id');
    }

    /**
     * Получить все работы (операции), относящиеся к данной технической системе.
     */
    public function operations()
    {
        return $this->belongsToMany(Operation::class, 'technical_system_operation',
            'technical_system_id', 'operation_id');
    }

    public function malfunction_codes()
    {
        return $this->hasMany(MalfunctionCode::class, 'technical_system_id');
    }

    public function rule_based_knowledge_bases()
    {
        return $this->hasMany(RuleBasedKnowledgeBase::class, 'technical_system_id');
    }

    public function malfunction_cause_rules_then()
    {
        return $this->hasMany(MalfunctionCauseRuleThen::class, 'technical_system_id');
    }

    public function operation_rules_for_malfunction_system()
    {
        return $this->hasMany(OperationRule::class, 'malfunction_system_id');
    }

    public function operation_rules_for_cause_system()
    {
        return $this->hasMany(OperationRule::class, 'cause_system_id');
    }
}
