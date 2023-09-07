<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OperationCondition
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, ConcreteOperationCondition> $concrete_operation_conditions
 * @property-read int|null $concrete_operation_conditions_count
 * @method static Builder|OperationCondition newModelQuery()
 * @method static Builder|OperationCondition newQuery()
 * @method static Builder|OperationCondition query()
 * @method static Builder|OperationCondition whereCreatedAt($value)
 * @method static Builder|OperationCondition whereDescription($value)
 * @method static Builder|OperationCondition whereId($value)
 * @method static Builder|OperationCondition whereName($value)
 * @method static Builder|OperationCondition whereUpdatedAt($value)
 * @mixin Builder
 */
class OperationCondition extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation_condition';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function concrete_operation_conditions()
    {
        return $this->hasMany('app\Models\ConcreteOperationCondition', 'operation_condition_id');
    }
}
