<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationRule extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation_rule';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'description',
        'type',
        'status',
        'rule_based_knowledge_base_id',
        'operation_id_if',
        'operation_status_if',
        'operation_result_id',
        'operation_id_then',
        'operation_status_then',
        'priority',
        'malfunction_system_id',
        'cause_system_id',
        'document_id',
    ];

    public function rule_based_knowledge_base()
    {
        return $this->belongsTo('app\Models\RuleBasedKnowledgeBase');
    }

    public function operation_if()
    {
        return $this->belongsTo('app\Models\Operation');
    }

    public function operation_result()
    {
        return $this->belongsTo('app\Models\OperationResult');
    }

    public function operation_then()
    {
        return $this->belongsTo('app\Models\Operation');
    }

    public function malfunction_system()
    {
        return $this->belongsTo('app\Models\TechnicalSystem');
    }

    public function cause_system()
    {
        return $this->belongsTo('app\Models\TechnicalSystem');
    }

    public function document()
    {
        return $this->belongsTo('app\Models\Document');
    }

    public function operation_rule_malfunction_codes()
    {
        return $this->hasMany('app\Models\OperationRuleMalfunctionCode', 'operation_rule_id');
    }
}
