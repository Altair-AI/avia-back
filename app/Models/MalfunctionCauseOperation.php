<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MalfunctionCauseOperation
 *
 * @property int $id
 * @property int $source_priority
 * @property int $code_priority
 * @property int $operation_id
 * @property int $malfunction_cause_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Operation $operation
 * @property-read MalfunctionCause $malfunction_cause
 * @method static Builder|MalfunctionCauseOperation newModelQuery()
 * @method static Builder|MalfunctionCauseOperation newQuery()
 * @method static Builder|MalfunctionCauseOperation query()
 * @method static Builder|MalfunctionCauseOperation whereCasePriority($value)
 * @method static Builder|MalfunctionCauseOperation whereCreatedAt($value)
 * @method static Builder|MalfunctionCauseOperation whereId($value)
 * @method static Builder|MalfunctionCauseOperation whereMalfunctionCauseId($value)
 * @method static Builder|MalfunctionCauseOperation whereOperationId($value)
 * @method static Builder|MalfunctionCauseOperation whereSourcePriority($value)
 * @method static Builder|MalfunctionCauseOperation whereUpdatedAt($value)
 * @mixin Builder
 */
class MalfunctionCauseOperation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_cause_operation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'source_priority',
        'case_priority',
        'operation_id',
        'malfunction_cause_id'
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

    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }

    public function malfunction_cause()
    {
        return $this->belongsTo(MalfunctionCause::class);
    }
}
