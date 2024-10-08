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
 * @property-read RuleBasedKnowledgeBase $rule_based_knowledge_bases
 * @property-read TechnicalSystem $technical_system
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

    // Типы проектов
    const PUBLIC_TYPE = 0;  // Проект виден всем пользователям системы
    const PRIVATE_TYPE = 1; // Проект виден только пользователям определенной организации, которая открыла данный проект

    // Статусы проектов
    const UNDER_EDITING_STATUS = 0; // На редактировании (проект находится на этапе разработки)
    const READY_TO_USE_STATUS = 1;  // Готов к использованию (формирование проекта завершено и он готов к работе)
    const OUTDATED_STATUS = 2;      // Устаревший (неактуальный проект с устаревшими или некорректными данными)

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
        'technical_system_id'
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

    public function licenses()
    {
        return $this->hasMany(License::class, 'project_id');
    }

    public function real_time_technical_systems()
    {
        return $this->hasMany(RealTimeTechnicalSystem::class, 'project_id');
    }

    public function case_based_knowledge_bases()
    {
        return $this->hasMany(CaseBasedKnowledgeBase::class, 'project_id');
    }

    public function rule_based_knowledge_base_projects()
    {
        return $this->hasMany(RuleBasedKnowledgeBaseProject::class, 'project_id');
    }

    /**
     * Получить все базы знаний с правилами, доступных в рамках данного проекта.
     */
    public function rule_based_knowledge_bases()
    {
        return $this->belongsToMany(RuleBasedKnowledgeBase::class, 'rule_based_knowledge_base_project',
            'project_id', 'rule_based_knowledge_base_id');
    }
}
