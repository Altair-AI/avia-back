<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo('app\Models\TechnicalSystem');
    }

    public function child_technical_systems()
    {
        return $this->hasMany('app\Models\TechnicalSystem', 'parent_technical_system_id');
    }

    public function projects()
    {
        return $this->hasMany('app\Models\Project', 'technical_system_id');
    }

    public function real_time_technical_systems()
    {
        return $this->hasMany('app\Models\RealTimeTechnicalSystem', 'technical_system_id');
    }

    public function technical_system_documents()
    {
        return $this->hasMany('app\Models\TechnicalSystemDocument', 'technical_system_id');
    }

    public function malfunction_codes()
    {
        return $this->hasMany('app\Models\MalfunctionCode', 'technical_system_id');
    }

    public function rule_based_knowledge_bases()
    {
        return $this->hasMany('app\Models\RuleBasedKnowledgeBase', 'technical_system_id');
    }

    public function malfunction_cause_rules_then()
    {
        return $this->hasMany('app\Models\MalfunctionCauseRuleThen', 'technical_system_id');
    }

    public function operation_rules_for_malfunction_system()
    {
        return $this->hasMany('app\Models\OperationRule', 'malfunction_system_id');
    }

    public function operation_rules_for_cause_system()
    {
        return $this->hasMany('app\Models\OperationRule', 'cause_system_id');
    }
}
