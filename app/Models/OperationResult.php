<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OperationResult
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, CompletedOperation> $completed_operations
 * @property-read int|null $completed_operations_count
 * @property-read Collection<int, ConcreteOperationResult> $concrete_operation_results
 * @property-read int|null $concrete_operation_results_count
 * @method static Builder|OperationResult newModelQuery()
 * @method static Builder|OperationResult newQuery()
 * @method static Builder|OperationResult query()
 * @method static Builder|OperationResult whereCreatedAt($value)
 * @method static Builder|OperationResult whereDescription($value)
 * @method static Builder|OperationResult whereId($value)
 * @method static Builder|OperationResult whereName($value)
 * @method static Builder|OperationResult whereUpdatedAt($value)
 * @mixin Builder
 */
class OperationResult extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation_result';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function concrete_operation_results()
    {
        return $this->hasMany(ConcreteOperationResult::class, 'operation_result_id');
    }

    public function completed_operations()
    {
        return $this->hasMany(CompletedOperation::class, 'operation_result_id');
    }

    public function operation_rules()
    {
        return $this->hasMany(OperationRule::class, 'operation_result_id');
    }
}
