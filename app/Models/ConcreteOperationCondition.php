<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ConcreteOperationCondition
 *
 * @property int $id
 * @property int $operation_id
 * @property int $operation_condition_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ConcreteOperationCondition newModelQuery()
 * @method static Builder|ConcreteOperationCondition newQuery()
 * @method static Builder|ConcreteOperationCondition query()
 * @method static Builder|ConcreteOperationCondition whereCreatedAt($value)
 * @method static Builder|ConcreteOperationCondition whereId($value)
 * @method static Builder|ConcreteOperationCondition whereOperationConditionId($value)
 * @method static Builder|ConcreteOperationCondition whereOperationId($value)
 * @method static Builder|ConcreteOperationCondition whereUpdatedAt($value)
 * @mixin Builder
 */
class ConcreteOperationCondition extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'concrete_operation_condition';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'operation_id',
        'operation_condition_id',
    ];

    public function operation()
    {
        return $this->belongsTo('app\Models\Operation');
    }

    public function operation_condition()
    {
        return $this->belongsTo('app\Models\OperationCondition');
    }
}
