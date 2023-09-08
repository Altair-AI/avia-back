<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CompletedOperation
 *
 * @property int $id
 * @property int $type
 * @property int $operation_id
 * @property int|null $previous_operation_id
 * @property int $operation_result_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CompletedOperation newModelQuery()
 * @method static Builder|CompletedOperation newQuery()
 * @method static Builder|CompletedOperation query()
 * @method static Builder|CompletedOperation whereCreatedAt($value)
 * @method static Builder|CompletedOperation whereId($value)
 * @method static Builder|CompletedOperation whereOperationId($value)
 * @method static Builder|CompletedOperation whereOperationResultId($value)
 * @method static Builder|CompletedOperation wherePreviousOperationId($value)
 * @method static Builder|CompletedOperation whereType($value)
 * @method static Builder|CompletedOperation whereUpdatedAt($value)
 * @method static Builder|CompletedOperation whereUserId($value)
 * @mixin Builder
 */
class CompletedOperation extends Model
{
    use HasFactory;

    // Типы выполненных работ
    const PREPARATORY_TYPE = 0;                  // Подготовительная работа
    const FAULT_CONFIRMATION_TYPE = 1;           // Подтверждение неисправности
    const TROUBLESHOOTING_TYPE = 2;              // Поиск и устранение неисправности
    const TROUBLESHOOTING_CONFIRMATION_TYPE = 3; // Подтверждение устранения неисправности
    const FINAL_TYPE = 4;                        // Заключительная работа

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
        'type',
        'operation_id',
        'previous_operation_id',
        'operation_result_id',
        'user_id',
    ];

    public function operation()
    {
        return $this->belongsTo('App\Models\Operation');
    }

    public function previous_operation()
    {
        return $this->belongsTo('App\Models\Operation');
    }

    public function operation_result()
    {
        return $this->belongsTo('App\Models\OperationResult');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function cases()
    {
        return $this->hasMany('App\Models\ECase', 'initial_completed_operation_id');
    }
}
