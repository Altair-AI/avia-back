<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CaseBasedKnowledgeBase
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $status
 * @property int $correctness
 * @property int $author
 * @property int $real_time_technical_system_id
 * @property int $project_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CaseBasedKnowledgeBase newModelQuery()
 * @method static Builder|CaseBasedKnowledgeBase newQuery()
 * @method static Builder|CaseBasedKnowledgeBase query()
 * @method static Builder|CaseBasedKnowledgeBase whereAuthor($value)
 * @method static Builder|CaseBasedKnowledgeBase whereCorrectness($value)
 * @method static Builder|CaseBasedKnowledgeBase whereCreatedAt($value)
 * @method static Builder|CaseBasedKnowledgeBase whereDescription($value)
 * @method static Builder|CaseBasedKnowledgeBase whereId($value)
 * @method static Builder|CaseBasedKnowledgeBase whereName($value)
 * @method static Builder|CaseBasedKnowledgeBase whereProjectId($value)
 * @method static Builder|CaseBasedKnowledgeBase whereRealTimeTechnicalSystemId($value)
 * @method static Builder|CaseBasedKnowledgeBase whereStatus($value)
 * @method static Builder|CaseBasedKnowledgeBase whereUpdatedAt($value)
 * @mixin Builder
 */
class CaseBasedKnowledgeBase extends Model
{
    use HasFactory;

    // Статусы доступности прецедентных баз знаний
    const PUBLIC_STATUS = 0;  // Открытая (доступна для просмотра всем пользователям)
    const PRIVATE_STATUS = 1; // Закрытая (доступна только внутри определенного проекта)

    // Статусы правильности прецедентных баз знаний
    const CORRECT_TYPE = 0;   // Корректная база знаний (проверена экспертом и может быть использована техниками)
    const INCORRECT_TYPE = 1; // Некорректная база знаний (не проверена экспертом и не может использоваться техниками)

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'case_based_knowledge_base';

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
        'real_time_technical_system_id',
        'project_id',
    ];

    public function author()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function real_time_technical_system()
    {
        return $this->belongsTo('App\Models\RealTimeTechnicalSystem');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function cases()
    {
        return $this->hasMany('App\Models\ECase', 'case_based_knowledge_base_id');
    }
}
