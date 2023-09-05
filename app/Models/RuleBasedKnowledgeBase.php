<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleBasedKnowledgeBase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rule_based_knowledge_base';

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
        'technical_system_id',
    ];

    public function author()
    {
        return $this->belongsTo('app\Models\User');
    }

    public function technical_system()
    {
        return $this->belongsTo('app\Models\TechnicalSystem');
    }

    public function rule_based_knowledge_base_projects()
    {
        return $this->hasMany('app\Models\RuleBasedKnowledgeBaseProject', 'rule_based_knowledge_base_id');
    }

    public function malfunction_cause_rules()
    {
        return $this->hasMany('app\Models\MalfunctionCauseRule', 'rule_based_knowledge_base_id');
    }

    public function operation_rules()
    {
        return $this->hasMany('app\Models\OperationRule', 'rule_based_knowledge_base_id');
    }
}
