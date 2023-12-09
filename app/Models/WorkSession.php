<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\WorkSession
 *
 * @property int $id
 * @property int $status
 * @property Carbon|null $stop_time
 * @property int malfunction_cause_rule_id
 * @property int user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, CompletedOperation> $completed_operations
 * @property-read int|null $completed_operations_count
 * @property-read Collection<int, OperationRuleList> $operation_rule_lists
 * @property-read int|null $operation_rule_lists_count
 * @property-read MalfunctionCauseRule $malfunction_cause_rule
 * @property-read User $user
 * @method static Builder|WorkSession newModelQuery()
 * @method static Builder|WorkSession newQuery()
 * @method static Builder|WorkSession query()
 * @method static Builder|WorkSession whereCreatedAt($value)
 * @method static Builder|WorkSession whereId($value)
 * @method static Builder|WorkSession whereMalfunctionCauseRuleId($value)
 * @method static Builder|WorkSession whereStatus($value)
 * @method static Builder|WorkSession whereStopTime($value)
 * @method static Builder|WorkSession whereUpdatedAt($value)
 * @method static Builder|WorkSession whereUserId($value)
 * @mixin Builder
 */
class WorkSession extends Model
{
    use HasFactory;
    use Filterable;

    // Статус рабочей сессии
    const MALFUNCTION_CAUSE_DETECTED_STATUS = 0; // Причины неисправности обнаружены
    const IN_PROGRESS_STATUS = 1;                // В процессе выполнения правил определения работ
    const DONE_STATUS = 2;                       // Выполнено

    protected $hidden = ['pivot'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_session';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'status',
        'stop_time',
        'malfunction_cause_rule_id',
        'user_id',
    ];

    public function malfunction_cause_rule()
    {
        return $this->belongsTo(MalfunctionCauseRule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function operation_rule_lists()
    {
        return $this->hasMany(OperationRuleList::class, 'work_session_id');
    }

    public function completed_operations()
    {
        return $this->hasMany(CompletedOperation::class, 'work_session_id');
    }

    /**
     * Получить все правила из оцереди для данной рабочей сессии.
     */
    public function execution_rule_queues()
    {
        return $this->hasManyThrough(ExecutionRuleQueue::class, OperationRuleList::class);
    }

    /**
     * Получить все выполненные и выполняемые правила для данной рабочей сессии.
     */
    public function execution_rules()
    {
        return $this->hasManyThrough(ExecutionRule::class, OperationRuleList::class);
    }
}
