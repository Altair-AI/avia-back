<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OperationRuleList
 *
 * @property int $id
 * @property int $status
 * @property int $work_session_id
 * @property int $operation_rule_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, ExecutionRule> $execution_rules
 * @property-read int|null $execution_rules_count
 * @property-read Collection<int, ExecutionRuleQueue> $execution_rule_queues
 * @property-read int|null $execution_rule_queues_count
 * @property-read OperationRule $operation_rule
 * @property-read WorkSession $work_session
 * @method static Builder|OperationRuleList newModelQuery()
 * @method static Builder|OperationRuleList newQuery()
 * @method static Builder|OperationRuleList query()
 * @method static Builder|OperationRuleList whereCreatedAt($value)
 * @method static Builder|OperationRuleList whereId($value)
 * @method static Builder|OperationRuleList whereOperationRuleId($value)
 * @method static Builder|OperationRuleList whereStatus($value)
 * @method static Builder|OperationRuleList whereUpdatedAt($value)
 * @method static Builder|OperationRuleList whereWorkSessionId($value)
 * @mixin Builder
 */
class OperationRuleList extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation_rule_list';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'status',
        'work_session_id',
        'operation_rule_id',
    ];

    public function work_session()
    {
        return $this->belongsTo(WorkSession::class);
    }

    public function operation_rule()
    {
        return $this->belongsTo(OperationRule::class);
    }

    public function execution_rule_queues()
    {
        return $this->hasMany(ExecutionRuleQueue::class, 'operation_rule_list_id');
    }

    public function execution_rules()
    {
        return $this->hasMany(ExecutionRule::class, 'operation_rule_list_id');
    }
}
