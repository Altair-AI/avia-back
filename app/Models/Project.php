<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Project
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $type
 * @property int $status
 * @property int $technical_system_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, CaseBasedKnowledgeBase> $case_based_knowledge_bases
 * @property-read int|null $case_based_knowledge_bases_count
 * @property-read Collection<int, License> $licenses
 * @property-read int|null $licenses_count
 * @method static Builder|Project newModelQuery()
 * @method static Builder|Project newQuery()
 * @method static Builder|Project query()
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereDescription($value)
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereName($value)
 * @method static Builder|Project whereStatus($value)
 * @method static Builder|Project whereTechnicalSystemId($value)
 * @method static Builder|Project whereType($value)
 * @method static Builder|Project whereUpdatedAt($value)
 * @mixin Builder
 */
class Project extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'status',
        'technical_system_id',
    ];

    public function technical_system()
    {
        return $this->belongsTo('app\Models\TechnicalSystem');
    }

    public function licenses()
    {
        return $this->hasMany('app\Models\License', 'project_id');
    }

    public function real_time_technical_systems()
    {
        return $this->hasMany('app\Models\RealTimeTechnicalSystem', 'project_id');
    }

    public function case_based_knowledge_bases()
    {
        return $this->hasMany('app\Models\CaseBasedKnowledgeBase', 'project_id');
    }

    public function rule_based_knowledge_base_projects()
    {
        return $this->hasMany('app\Models\RuleBasedKnowledgeBaseProject', 'project_id');
    }
}
