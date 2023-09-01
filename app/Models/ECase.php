<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ECase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'case';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'date',
        'card_number',
        'malfunction_detection_stage_id',
        'malfunction_system_id',
        'system_id_for_repair',
        'initial_completed_operation_id',
        'case_based_knowledge_base_id',
    ];

    public function malfunction_detection_stage()
    {
        return $this->belongsTo('app\Models\MalfunctionDetectionStage');
    }

    public function malfunction_system()
    {
        return $this->belongsTo('app\Models\RealTimeTechnicalSystem');
    }

    public function system_for_repair()
    {
        return $this->belongsTo('app\Models\RealTimeTechnicalSystem');
    }

    public function initial_completed_operation()
    {
        return $this->belongsTo('app\Models\CompletedOperation');
    }

    public function case_based_knowledge_base()
    {
        return $this->belongsTo('app\Models\CaseBasedKnowledgeBase');
    }

    public function malfunction_code_cases()
    {
        return $this->hasMany('app\Models\MalfunctionCodeCase', 'case_id');
    }

    public function external_malfunction_sign_cases()
    {
        return $this->hasMany('app\Models\ExternalMalfunctionSignCase', 'case_id');
    }

    public function malfunction_consequence_cases()
    {
        return $this->hasMany('app\Models\MalfunctionConsequenceCase', 'case_id');
    }
}
