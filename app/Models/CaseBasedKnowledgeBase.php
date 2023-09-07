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
        return $this->belongsTo('app\Models\User');
    }

    public function real_time_technical_system()
    {
        return $this->belongsTo('app\Models\RealTimeTechnicalSystem');
    }

    public function project()
    {
        return $this->belongsTo('app\Models\Project');
    }

    public function cases()
    {
        return $this->hasMany('app\Models\ECase', 'case_based_knowledge_base_id');
    }
}
