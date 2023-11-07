<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ConcreteOperationResult
 *
 * @property int $id
 * @property int $operation_id
 * @property int $operation_result_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Operation $operation
 * @property-read OperationResult $operation_result
 * @method static Builder|ConcreteOperationResult newModelQuery()
 * @method static Builder|ConcreteOperationResult newQuery()
 * @method static Builder|ConcreteOperationResult query()
 * @method static Builder|ConcreteOperationResult whereCreatedAt($value)
 * @method static Builder|ConcreteOperationResult whereId($value)
 * @method static Builder|ConcreteOperationResult whereOperationId($value)
 * @method static Builder|ConcreteOperationResult whereOperationResultId($value)
 * @method static Builder|ConcreteOperationResult whereUpdatedAt($value)
 * @mixin Builder
 */
class ConcreteOperationResult extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'concrete_operation_result';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'operation_id',
        'operation_result_id',
    ];

    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }

    public function operation_result()
    {
        return $this->belongsTo(OperationResult::class);
    }
}
