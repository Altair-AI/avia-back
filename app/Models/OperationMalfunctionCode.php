<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OperationMalfunctionCode
 *
 * @property int $id
 * @property int $operation_id
 * @property int $malfunction_code_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Operation $operation
 * @property-read MalfunctionCode $malfunction_code
 * @method static Builder|OperationMalfunctionCode newModelQuery()
 * @method static Builder|OperationMalfunctionCode newQuery()
 * @method static Builder|OperationMalfunctionCode query()
 * @method static Builder|OperationMalfunctionCode whereCreatedAt($value)
 * @method static Builder|OperationMalfunctionCode whereId($value)
 * @method static Builder|OperationMalfunctionCode whereMalfunctionCodeId($value)
 * @method static Builder|OperationMalfunctionCode whereOperationId($value)
 * @method static Builder|OperationMalfunctionCode whereUpdatedAt($value)
 * @mixin Builder
 */
class OperationMalfunctionCode extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation_malfunction_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'operation_id',
        'malfunction_code_id'
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

    public function malfunction_code()
    {
        return $this->belongsTo(MalfunctionCode::class);
    }
}
