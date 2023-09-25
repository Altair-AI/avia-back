<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function parent_technical_system()
    {
        return $this->belongsTo('App\Models\TechnicalSystem');
    }

    public function child_technical_systems()
    {
        return $this->hasMany('App\Models\TechnicalSystem', 'parent_technical_system_id');
    }

    public function projects()
    {
        return $this->hasMany('App\Models\Project', 'technical_system_id');
    }

    public function real_time_technical_systems()
    {
        return $this->hasMany('App\Models\RealTimeTechnicalSystem', 'technical_system_id');
    }

    public function technical_system_documents()
    {
        return $this->hasMany('App\Models\TechnicalSystemDocument', 'technical_system_id');
    }

    public function malfunction_codes()
    {
        return $this->hasMany('App\Models\MalfunctionCode', 'technical_system_id');
    }

    public function rule_based_knowledge_bases()
    {
        return $this->hasMany('App\Models\RuleBasedKnowledgeBase', 'technical_system_id');
    }

    public function malfunction_cause_rules_then()
    {
        return $this->hasMany('App\Models\MalfunctionCauseRuleThen', 'technical_system_id');
    }

    public function operation_rules_for_malfunction_system()
    {
        return $this->hasMany('App\Models\OperationRule', 'malfunction_system_id');
    }

    public function operation_rules_for_cause_system()
    {
        return $this->hasMany('App\Models\OperationRule', 'cause_system_id');
    }
}
