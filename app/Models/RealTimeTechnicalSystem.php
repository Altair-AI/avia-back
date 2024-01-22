<?php

namespace App\Models;

use App\Models\Traits\Filterable;
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
 * @property-read Project $project
 * @property-read Collection<int, ECase> $system_for_repair_cases
 * @property-read int|null $system_for_repair_cases_count
 * @property-read TechnicalSystem $technical_system
 * @property-read User $users
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
    use HasFactory, Filterable;

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
        'project_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<string>
     */
    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at'
    ];

    public function technical_system()
    {
        return $this->belongsTo(TechnicalSystem::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function real_time_technical_system_users()
    {
        return $this->hasMany(RealTimeTechnicalSystemUser::class, 'real_time_technical_system_id');
    }

    public function case_based_knowledge_bases()
    {
        return $this->hasMany(CaseBasedKnowledgeBase::class, 'real_time_technical_system_id');
    }

    public function system_for_repair_cases()
    {
        return $this->hasMany(ECase::class, 'system_id_for_repair');
    }

    /**
     * Получить всех пользователей, которые имеют доступ к данной технической системе реального времени.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'real_time_technical_system_user',
            'real_time_technical_system_id', 'user_id');
    }
}
