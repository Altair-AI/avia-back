<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
