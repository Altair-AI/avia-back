<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleBasedKnowledgeBaseProject extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rule_based_knowledge_base_project';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'rule_based_knowledge_base_id',
        'project_id',
    ];

    public function rule_based_knowledge_base()
    {
        return $this->belongsTo('app\Models\RuleBasedKnowledgeBase');
    }

    public function project()
    {
        return $this->belongsTo('app\Models\Project');
    }
}
