<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MalfunctionCauseRuleIf
 *
 * @property int $id
 * @property int $malfunction_cause_rule_id
 * @property int $malfunction_code_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MalfunctionCauseRule $malfunction_cause_rule
 * @method static Builder|MalfunctionCauseRuleIf newModelQuery()
 * @method static Builder|MalfunctionCauseRuleIf newQuery()
 * @method static Builder|MalfunctionCauseRuleIf query()
 * @method static Builder|MalfunctionCauseRuleIf whereCreatedAt($value)
 * @method static Builder|MalfunctionCauseRuleIf whereId($value)
 * @method static Builder|MalfunctionCauseRuleIf whereMalfunctionCauseRuleId($value)
 * @method static Builder|MalfunctionCauseRuleIf whereMalfunctionCodeId($value)
 * @method static Builder|MalfunctionCauseRuleIf whereUpdatedAt($value)
 * @mixin Builder
 */
class MalfunctionCauseRuleIf extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_cause_rule_if';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'malfunction_cause_rule_id',
        'malfunction_code_id',
    ];

    public function malfunction_cause_rule()
    {
        return $this->belongsTo('App\Models\MalfunctionCauseRule');
    }

    public function malfunction_code()
    {
        return $this->belongsTo('App\Models\MalfunctionCode');
    }
}
