<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ECase
 *
 * @property int $id
 * @property string $date
 * @property string $card_number
 * @property int $malfunction_detection_stage_id
 * @property int $malfunction_system_id
 * @property int $system_id_for_repair
 * @property int|null $initial_completed_operation_id
 * @property int $case_based_knowledge_base_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read CaseBasedKnowledgeBase $case_based_knowledge_base
 * @property-read CompletedOperation|null $initial_completed_operation
 * @method static Builder|ECase newModelQuery()
 * @method static Builder|ECase newQuery()
 * @method static Builder|ECase query()
 * @method static Builder|ECase whereCardNumber($value)
 * @method static Builder|ECase whereCaseBasedKnowledgeBaseId($value)
 * @method static Builder|ECase whereCreatedAt($value)
 * @method static Builder|ECase whereDate($value)
 * @method static Builder|ECase whereId($value)
 * @method static Builder|ECase whereInitialCompletedOperationId($value)
 * @method static Builder|ECase whereMalfunctionDetectionStageId($value)
 * @method static Builder|ECase whereMalfunctionSystemId($value)
 * @method static Builder|ECase whereSystemIdForRepair($value)
 * @method static Builder|ECase whereUpdatedAt($value)
 * @mixin Builder
 */
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
        return $this->belongsTo('App\Models\MalfunctionDetectionStage');
    }

    public function malfunction_system()
    {
        return $this->belongsTo('App\Models\RealTimeTechnicalSystem');
    }

    public function system_for_repair()
    {
        return $this->belongsTo('App\Models\RealTimeTechnicalSystem');
    }

    public function initial_completed_operation()
    {
        return $this->belongsTo('App\Models\CompletedOperation');
    }

    public function case_based_knowledge_base()
    {
        return $this->belongsTo('App\Models\CaseBasedKnowledgeBase');
    }

    public function malfunction_code_cases()
    {
        return $this->hasMany('App\Models\MalfunctionCodeCase', 'case_id');
    }

    public function external_malfunction_sign_cases()
    {
        return $this->hasMany('App\Models\ExternalMalfunctionSignCase', 'case_id');
    }

    public function malfunction_consequence_cases()
    {
        return $this->hasMany('App\Models\MalfunctionConsequenceCase', 'case_id');
    }
}
