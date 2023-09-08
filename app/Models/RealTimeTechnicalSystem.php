<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\RealTimeTechnicalSystem
 *
 * @property int $id
 * @property string $registration_code
 * @property string|null $registration_description
 * @property int|null $operation_time_from_start
 * @property int|null $operation_time_from_last_repair
 * @property int $technical_system_id
 * @property int $project_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, CaseBasedKnowledgeBase> $case_based_knowledge_bases
 * @property-read int|null $case_based_knowledge_bases_count
 * @property-read Collection<int, ECase> $malfunction_system_cases
 * @property-read int|null $malfunction_system_cases_count
 * @property-read Project $project
 * @property-read Collection<int, ECase> $system_for_repair_cases
 * @property-read int|null $system_for_repair_cases_count
 * @method static Builder|RealTimeTechnicalSystem newModelQuery()
 * @method static Builder|RealTimeTechnicalSystem newQuery()
 * @method static Builder|RealTimeTechnicalSystem query()
 * @method static Builder|RealTimeTechnicalSystem whereCreatedAt($value)
 * @method static Builder|RealTimeTechnicalSystem whereId($value)
 * @method static Builder|RealTimeTechnicalSystem whereOperationTimeFromLastRepair($value)
 * @method static Builder|RealTimeTechnicalSystem whereOperationTimeFromStart($value)
 * @method static Builder|RealTimeTechnicalSystem whereProjectId($value)
 * @method static Builder|RealTimeTechnicalSystem whereRegistrationCode($value)
 * @method static Builder|RealTimeTechnicalSystem whereRegistrationDescription($value)
 * @method static Builder|RealTimeTechnicalSystem whereTechnicalSystemId($value)
 * @method static Builder|RealTimeTechnicalSystem whereUpdatedAt($value)
 * @mixin Builder
 */
class RealTimeTechnicalSystem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'real_time_technical_system';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'registration_code',
        'registration_description',
        'operation_time_from_start',
        'operation_time_from_last_repair',
        'technical_system_id',
        'project_id',
    ];

    public function technical_system()
    {
        return $this->belongsTo('App\Models\TechnicalSystem');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function real_time_technical_system_users()
    {
        return $this->hasMany('App\Models\RealTimeTechnicalSystemUser', 'real_time_technical_system_id');
    }

    public function case_based_knowledge_bases()
    {
        return $this->hasMany('App\Models\CaseBasedKnowledgeBase', 'real_time_technical_system_id');
    }

    public function malfunction_system_cases()
    {
        return $this->hasMany('App\Models\ECase', 'malfunction_system_id');
    }

    public function system_for_repair_cases()
    {
        return $this->hasMany('App\Models\ECase', 'system_id_for_repair');
    }
}
