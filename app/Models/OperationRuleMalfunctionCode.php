<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OperationRuleMalfunctionCode
 *
 * @property int $id
 * @property int $malfunction_code_id
 * @property int $operation_rule_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MalfunctionCode $malfunction_code
 * @property-read OperationRule $operation_rule
 * @method static Builder|OperationRuleMalfunctionCode newModelQuery()
 * @method static Builder|OperationRuleMalfunctionCode newQuery()
 * @method static Builder|OperationRuleMalfunctionCode query()
 * @method static Builder|OperationRuleMalfunctionCode whereCreatedAt($value)
 * @method static Builder|OperationRuleMalfunctionCode whereId($value)
 * @method static Builder|OperationRuleMalfunctionCode whereMalfunctionCodeId($value)
 * @method static Builder|OperationRuleMalfunctionCode whereOperationRuleId($value)
 * @method static Builder|OperationRuleMalfunctionCode whereUpdatedAt($value)
 * @mixin Builder
 */
class OperationRuleMalfunctionCode extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation_rule_malfunction_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'malfunction_code_id',
        'operation_rule_id',
    ];

    public function malfunction_code()
    {
        return $this->belongsTo(MalfunctionCode::class);
    }

    public function operation_rule()
    {
        return $this->belongsTo(OperationRule::class);
    }
}
