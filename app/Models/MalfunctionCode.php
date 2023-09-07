<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MalfunctionCode
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property int $technical_system_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, MalfunctionCauseRuleIf> $malfunction_cause_rules_if
 * @property-read int|null $malfunction_cause_rules_if_count
 * @method static Builder|MalfunctionCode newModelQuery()
 * @method static Builder|MalfunctionCode newQuery()
 * @method static Builder|MalfunctionCode query()
 * @method static Builder|MalfunctionCode whereCreatedAt($value)
 * @method static Builder|MalfunctionCode whereId($value)
 * @method static Builder|MalfunctionCode whereName($value)
 * @method static Builder|MalfunctionCode whereTechnicalSystemId($value)
 * @method static Builder|MalfunctionCode whereType($value)
 * @method static Builder|MalfunctionCode whereUpdatedAt($value)
 * @mixin Builder
 */
class MalfunctionCode extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'type',
        'technical_system_id',
    ];

    public function technical_system()
    {
        return $this->belongsTo('app\Models\TechnicalSystem');
    }

    public function malfunction_code_cases()
    {
        return $this->hasMany('app\Models\MalfunctionCodeCase', 'malfunction_code_id');
    }

    public function malfunction_cause_rules_if()
    {
        return $this->hasMany('app\Models\MalfunctionCauseRuleIf', 'malfunction_code_id');
    }

    public function operation_rule_malfunction_codes()
    {
        return $this->hasMany('app\Models\OperationRuleMalfunctionCode', 'malfunction_code_id');
    }
}
