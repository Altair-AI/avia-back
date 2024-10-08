<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OperationHierarchy
 *
 * @property int $id
 * @property string|null $designation
 * @property int|null $sequence_number
 * @property int $parent_operation_id
 * @property int $child_operation_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Operation|null $child_operation
 * @property-read Operation|null $parent_operation
 * @method static Builder|OperationHierarchy newModelQuery()
 * @method static Builder|OperationHierarchy newQuery()
 * @method static Builder|OperationHierarchy query()
 * @method static Builder|OperationHierarchy whereChildOperationId($value)
 * @method static Builder|OperationHierarchy whereCreatedAt($value)
 * @method static Builder|OperationHierarchy whereDesignation($value)
 * @method static Builder|OperationHierarchy whereId($value)
 * @method static Builder|OperationHierarchy whereParentOperationId($value)
 * @method static Builder|OperationHierarchy whereSequenceNumber($value)
 * @method static Builder|OperationHierarchy whereUpdatedAt($value)
 * @mixin Builder
 */
class OperationHierarchy extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation_hierarchy';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'designation',
        'sequence_number',
        'parent_operation_id',
        'child_operation_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function parent_operation()
    {
        return $this->belongsTo(Operation::class);
    }

    public function child_operation()
    {
        return $this->belongsTo(Operation::class);
    }
}
