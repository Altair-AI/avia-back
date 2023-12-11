<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ExecutionRule
 *
 * @property int $id
 * @property int $status
 * @property int $operation_id
 * @property int $operation_status
 * @property int $operation_result_id
 * @property int $operation_rule_list_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Operation $operation
 * @property-read OperationResult $operation_result
 * @property-read OperationRuleList $operation_rule_list
 * @method static Builder|ExecutionRule newModelQuery()
 * @method static Builder|ExecutionRule newQuery()
 * @method static Builder|ExecutionRule query()
 * @method static Builder|ExecutionRule whereCreatedAt($value)
 * @method static Builder|ExecutionRule whereId($value)
 * @method static Builder|ExecutionRule whereOperationId($value)
 * @method static Builder|ExecutionRule whereOperationResultId($value)
 * @method static Builder|ExecutionRule whereOperationRuleListId($value)
 * @method static Builder|ExecutionRule whereStatus($value)
 * @method static Builder|ExecutionRule whereOperationStatus($value)
 * @method static Builder|ExecutionRule whereUpdatedAt($value)
 * @mixin Builder
 */
class ExecutionRule extends Model
{
    use HasFactory;

    // Статус правила
    const IN_PROGRESS_RULE_STATUS = 0;  // Выполнение правила
    const NO_OPERATION_RULE_STATUS = 1; // Отсутствует факт работы
    const NO_STATUS_RULE_STATUS = 2;    // Отсутствует факт статуса работы
    const NO_RESULT_RULE_STATUS = 3;    // Отсутствует факт результата работы
    const DONE_RULE_STATUS = 4;         // Выполнено

    // Статус работы
    const NOT_COMPLETED_OPERATION_STATUS = 0; // Не выполнена
    const COMPLETED_OPERATION_STATUS = 1;     // Выполнена
    const INITIATED_OPERATION_STATUS = 2;     // Инициирована

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'execution_rule';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'status',
        'operation_id',
        'operation_status',
        'operation_result_id',
        'operation_rule_list_id',
    ];

    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }

    public function operation_result()
    {
        return $this->belongsTo(OperationResult::class);
    }

    public function operation_rule_list()
    {
        return $this->belongsTo(OperationRuleList::class);
    }
}
