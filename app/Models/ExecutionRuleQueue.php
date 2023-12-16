<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ExecutionRuleQueue
 *
 * @property int $id
 * @property int $operation_rule_list_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read OperationRuleList $operation_rule_list
 * @method static Builder|ExecutionRuleQueue newModelQuery()
 * @method static Builder|ExecutionRuleQueue newQuery()
 * @method static Builder|ExecutionRuleQueue query()
 * @method static Builder|ExecutionRuleQueue whereCreatedAt($value)
 * @method static Builder|ExecutionRuleQueue whereId($value)
 * @method static Builder|ExecutionRuleQueue whereOperationRuleListId($value)
 * @method static Builder|ExecutionRuleQueue whereUpdatedAt($value)
 * @mixin Builder
 */
class ExecutionRuleQueue extends Model
{
    use HasFactory;

    protected $hidden = ['laravel_through_key'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'execution_rule_queue';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'operation_rule_list_id',
    ];

    public function operation_rule_list()
    {
        return $this->belongsTo(OperationRuleList::class);
    }
}
