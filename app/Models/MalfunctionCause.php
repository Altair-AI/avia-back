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
 * @property-read Collection<int, OperationRule> $operation_rules
 * @property-read MalfunctionCauseRule $malfunction_cause_rules
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
    use HasFactory;
    use Filterable;

    protected $hidden = ['pivot'];

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

    public function malfunction_cause_rule_malfunction_causes()
    {
        return $this->hasMany(MalfunctionCauseRuleMalfunctionCause::class, 'malfunction_cause_id');
    }

    public function operation_rules()
    {
        return $this->hasMany(OperationRule::class, 'malfunction_cause_id');
    }

    /**
     * Получить все правила определения причины неисправности относящихся к данной причине.
     */
    public function malfunction_cause_rules()
    {
        return $this->belongsToMany(MalfunctionCauseRule::class, 'malfunction_cause_rule_malfunction_cause',
            'malfunction_cause_id', 'malfunction_cause_rule_id');
    }
}
