<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CompletedOperation
 *
 * @property int $id
 * @property int $operation_id
 * @property int|null $previous_operation_id
 * @property int $operation_status
 * @property int $operation_result_id
 * @property int $work_session_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, ECase> $cases
 * @property-read int|null $cases_count
 * @property-read Operation $operation
 * @property-read OperationResult $operation_result
 * @property-read Operation $previous_operation
 * @property-read WorkSession $work_session
 * @method static Builder|CompletedOperation newModelQuery()
 * @method static Builder|CompletedOperation newQuery()
 * @method static Builder|CompletedOperation query()
 * @method static Builder|CompletedOperation whereCreatedAt($value)
 * @method static Builder|CompletedOperation whereId($value)
 * @method static Builder|CompletedOperation whereOperationId($value)
 * @method static Builder|CompletedOperation whereOperationResultId($value)
 * @method static Builder|CompletedOperation whereOperationStatus($value)
 * @method static Builder|CompletedOperation wherePreviousOperationId($value)
 * @method static Builder|CompletedOperation whereUpdatedAt($value)
 * @method static Builder|CompletedOperation whereWorkSessionId($value)
 * @mixin Builder
 */
class CompletedOperation extends Model
{
    use HasFactory;

    // Статус работы
    const NOT_COMPLETED_OPERATION_STATUS = 0; // Не выполнена
    const COMPLETED_OPERATION_STATUS = 1;     // Выполнена
    const INITIATED_OPERATION_STATUS = 2;     // Инициирована

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'completed_operation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'operation_id',
        'previous_operation_id',
        'operation_status',
        'operation_result_id',
        'work_session_id'
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

    public function previous_operation()
    {
        return $this->belongsTo(Operation::class);
    }

    public function operation_result()
    {
        return $this->belongsTo(OperationResult::class);
    }

    public function work_session()
    {
        return $this->belongsTo(WorkSession::class);
    }

    public function cases()
    {
        return $this->hasMany(ECase::class, 'initial_completed_operation_id');
    }
}
