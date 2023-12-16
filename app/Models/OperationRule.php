<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OperationRule
 *
 * @property int $id
 * @property string $context
 * @property string|null $description
 * @property int $document_id
 * @property int $malfunction_cause_id
 * @property int $malfunction_system_id
 * @property int $operation_id_if
 * @property int $operation_status_if
 * @property int $operation_result_id_if
 * @property int $operation_id_then
 * @property int $operation_status_then
 * @property int $operation_result_id_then
 * @property int $priority
 * @property int $repeat_voice
 * @property int $rule_based_knowledge_base_id
 * @property int $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Document $document
 * @property-read RuleBasedKnowledgeBase $rule_based_knowledge_base
 * @property-read Operation|null $operation_if
 * @property-read OperationResult $operation_result_if
 * @property-read Operation|null $operation_then
 * @property-read OperationResult $operation_result_then
 * @property-read TechnicalSystem $malfunction_system
 * @property-read MalfunctionCause $malfunction_cause
 * @property-read Collection<int, OperationRuleList> $operation_rule_lists
 * @property-read int|null $operation_rule_lists_count
 * @method static Builder|OperationRule newModelQuery()
 * @method static Builder|OperationRule newQuery()
 * @method static Builder|OperationRule query()
 * @method static Builder|OperationRule whereContext($value)
 * @method static Builder|OperationRule whereCreatedAt($value)
 * @method static Builder|OperationRule whereDescription($value)
 * @method static Builder|OperationRule whereDocumentId($value)
 * @method static Builder|OperationRule whereId($value)
 * @method static Builder|OperationRule whereMalfunctionCauseId($value)
 * @method static Builder|OperationRule whereMalfunctionSystemId($value)
 * @method static Builder|OperationRule whereOperationIdIf($value)
 * @method static Builder|OperationRule whereOperationIdThen($value)
 * @method static Builder|OperationRule whereOperationResultIdIf($value)
 * @method static Builder|OperationRule whereOperationResultIdThen($value)
 * @method static Builder|OperationRule whereOperationStatusIf($value)
 * @method static Builder|OperationRule whereOperationStatusThen($value)
 * @method static Builder|OperationRule wherePriority($value)
 * @method static Builder|OperationRule whereRepeatVoice($value)
 * @method static Builder|OperationRule whereRuleBasedKnowledgeBaseId($value)
 * @method static Builder|OperationRule whereType($value)
 * @method static Builder|OperationRule whereUpdatedAt($value)
 * @mixin Builder
 */
class OperationRule extends Model
{
    use HasFactory;
    use Filterable;

    // Типы правил
    const DISPOSABLE_TYPE = 0; // Одноразовое правило
    const REUSABLE_TYPE = 1;   // Многоразовое правило

    // Статусы операций (условия)
    const NOT_COMPLETED_OPERATION_IF_STATUS = 0; // Работа не выполнена
    const COMPLETED_OPERATION_IF_STATUS = 1;     // Работа выполнена
    const INITIATED_OPERATION_IF_STATUS = 2;     // Работа инициирована

    // Статусы операций (действия)
    const NOT_COMPLETED_OPERATION_THEN_STATUS = 0; // Работа не выполнена
    const COMPLETED_OPERATION_THEN_STATUS = 1;     // Работа выполнена
    const INITIATED_OPERATION_THEN_STATUS = 2;     // Работа инициирована

    // Флаг показывающий надо ли повторять озвучку
    const REQUIRED_REPEAT_VOICE = 0;     // Требуется
    const NOT_REQUIRED_REPEAT_VOICE = 1; // Не требуется

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
        'priority',
        'repeat_voice',
        'context',
        'rule_based_knowledge_base_id',
        'operation_id_if',
        'operation_status_if',
        'operation_result_id_if',
        'operation_id_then',
        'operation_status_then',
        'operation_result_id_then',
        'malfunction_cause_id',
        'malfunction_system_id',
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

    public function operation_result_if()
    {
        return $this->belongsTo(OperationResult::class);
    }

    public function operation_then()
    {
        return $this->belongsTo(Operation::class);
    }

    public function operation_result_then()
    {
        return $this->belongsTo(OperationResult::class);
    }

    public function malfunction_system()
    {
        return $this->belongsTo(TechnicalSystem::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function malfunction_cause()
    {
        return $this->belongsTo(MalfunctionCause::class);
    }

    public function operation_rule_malfunction_codes()
    {
        return $this->hasMany(OperationRuleMalfunctionCode::class, 'operation_rule_id');
    }

    public function operation_rule_lists()
    {
        return $this->hasMany(OperationRuleList::class, 'operation_rule_id');
    }
}
