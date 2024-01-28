<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MalfunctionCause
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, ECase> $cases
 * @property-read int|null $cases_count
 * @property-read Collection<int, MalfunctionCauseOperation> $malfunction_cause_operations
 * @property-read int|null $malfunction_cause_operations_count
 * @property-read Collection<int, MalfunctionCauseRuleMalfunctionCause> $malfunction_cause_rule_malfunction_causes
 * @property-read int|null $malfunction_cause_rule_malfunction_causes_count
 * @property-read Collection<int, OperationRule> $operation_rules
 * @property-read int|null $operation_rules_count
 * @property-read MalfunctionCauseRule $malfunction_cause_rules
 * @property-read Operation $operations
 * @method static Builder|MalfunctionCause newModelQuery()
 * @method static Builder|MalfunctionCause newQuery()
 * @method static Builder|MalfunctionCause query()
 * @method static Builder|MalfunctionCause whereCreatedAt($value)
 * @method static Builder|MalfunctionCause whereId($value)
 * @method static Builder|MalfunctionCause whereName($value)
 * @method static Builder|MalfunctionCause whereUpdatedAt($value)
 * @mixin Builder
 */
class MalfunctionCause extends Model
{
    use HasFactory, Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_cause';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<string>
     */
    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at'
    ];

    public function operation_rules()
    {
        return $this->hasMany(OperationRule::class, 'malfunction_cause_id');
    }

    public function cases()
    {
        return $this->hasMany(ECase::class, 'malfunction_cause_id');
    }

    public function malfunction_cause_rule_malfunction_causes()
    {
        return $this->hasMany(MalfunctionCauseRuleMalfunctionCause::class, 'malfunction_cause_id');
    }

    /**
     * Получить все правила определения причины неисправности относящихся к данной причине.
     */
    public function malfunction_cause_rules()
    {
        return $this->belongsToMany(MalfunctionCauseRule::class, 'malfunction_cause_rule_malfunction_cause',
            'malfunction_cause_id', 'malfunction_cause_rule_id');
    }

    public function malfunction_cause_operations()
    {
        return $this->hasMany(MalfunctionCauseOperation::class, 'malfunction_cause_id');
    }

    /**
     * Получить все работы (операции) связанных с данной причиной.
     */
    public function operations()
    {
        return $this->belongsToMany(Operation::class, 'malfunction_cause_operation',
            'malfunction_cause_id', 'operation_id');
    }
}
