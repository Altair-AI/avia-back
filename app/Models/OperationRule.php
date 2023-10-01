<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OperationRule
 *
 * @property int $id
 * @property string|null $description
 * @property int $type
 * @property int $status
 * @property int $rule_based_knowledge_base_id
 * @property int $operation_id_if
 * @property int $operation_status_if
 * @property int $operation_result_id
 * @property int $operation_id_then
 * @property int $operation_status_then
 * @property int $priority
 * @property int $malfunction_system_id
 * @property int $cause_system_id
 * @property int $document_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Document $document
 * @property-read Operation|null $operation_if
 * @property-read OperationResult $operation_result
 * @property-read Operation|null $operation_then
 * @method static Builder|OperationRule newModelQuery()
 * @method static Builder|OperationRule newQuery()
 * @method static Builder|OperationRule query()
 * @method static Builder|OperationRule whereCauseSystemId($value)
 * @method static Builder|OperationRule whereCreatedAt($value)
 * @method static Builder|OperationRule whereDescription($value)
 * @method static Builder|OperationRule whereDocumentId($value)
 * @method static Builder|OperationRule whereId($value)
 * @method static Builder|OperationRule whereMalfunctionSystemId($value)
 * @method static Builder|OperationRule whereOperationIdIf($value)
 * @method static Builder|OperationRule whereOperationIdThen($value)
 * @method static Builder|OperationRule whereOperationResultId($value)
 * @method static Builder|OperationRule whereOperationStatusIf($value)
 * @method static Builder|OperationRule whereOperationStatusThen($value)
 * @method static Builder|OperationRule wherePriority($value)
 * @method static Builder|OperationRule whereRuleBasedKnowledgeBaseId($value)
 * @method static Builder|OperationRule whereStatus($value)
 * @method static Builder|OperationRule whereType($value)
 * @method static Builder|OperationRule whereUpdatedAt($value)
 * @mixin Builder
 */
class OperationRule extends Model
{
    use HasFactory;

    // Типы правил
    const DISPOSABLE_TYPE = 0; // Одноразовое правило
    const REUSABLE_TYPE = 1;   // Многоразовое правило

    // Статусы правил
    const COMPLETED_RULE_STATUS = 0;     // Правило выполнено
    const NOT_COMPLETED_RULE_STATUS = 1; // Правило не выполнено

    // Статусы операций (условия)
    const COMPLETED_OPERATION_IF_STATUS = 0;     // Работа выполнена
    const NOT_COMPLETED_OPERATION_IF_STATUS = 1; // Работа не выполнена
    const INITIATED_OPERATION_IF_STATUS = 2;     // Работа инициирована

    // Статусы операций (действия)
    const COMPLETED_OPERATION_THEN_STATUS = 0;     // Работа выполнена
    const NOT_COMPLETED_OPERATION_THEN_STATUS = 1; // Работа не выполнена
    const INITIATED_OPERATION_THEN_STATUS = 2;     // Работа инициирована

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
        return $this->belongsTo(RuleBasedKnowledgeBase::class);
    }

    public function operation_if()
    {
        return $this->belongsTo(Operation::class);
    }

    public function operation_result()
    {
        return $this->belongsTo(OperationResult::class);
    }

    public function operation_then()
    {
        return $this->belongsTo(Operation::class);
    }

    public function malfunction_system()
    {
        return $this->belongsTo(TechnicalSystem::class);
    }

    public function cause_system()
    {
        return $this->belongsTo(TechnicalSystem::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function operation_rule_malfunction_codes()
    {
        return $this->hasMany(OperationRuleMalfunctionCode::class, 'operation_rule_id');
    }
}
