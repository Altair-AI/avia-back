<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MalfunctionCauseRuleMalfunctionCause
 *
 * @property int $id
 * @property int $malfunction_cause_rule_id
 * @property int $malfunction_cause_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MalfunctionCauseRule $malfunction_cause_rule
 * @property-read MalfunctionCause $malfunction_cause
 * @method static Builder|MalfunctionCauseRuleMalfunctionCause newModelQuery()
 * @method static Builder|MalfunctionCauseRuleMalfunctionCause newQuery()
 * @method static Builder|MalfunctionCauseRuleMalfunctionCause query()
 * @method static Builder|MalfunctionCauseRuleMalfunctionCause whereCreatedAt($value)
 * @method static Builder|MalfunctionCauseRuleMalfunctionCause whereId($value)
 * @method static Builder|MalfunctionCauseRuleMalfunctionCause whereMalfunctionCauseRuleId($value)
 * @method static Builder|MalfunctionCauseRuleMalfunctionCause whereMalfunctionCauseId($value)
 * @method static Builder|MalfunctionCauseRuleMalfunctionCause whereUpdatedAt($value)
 * @mixin Builder
 */
class MalfunctionCauseRuleMalfunctionCause extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_cause_rule_malfunction_cause';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'malfunction_cause_rule_id',
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

    public function malfunction_cause_rule()
    {
        return $this->belongsTo(MalfunctionCauseRule::class);
    }

    public function malfunction_cause()
    {
        return $this->belongsTo(MalfunctionCause::class);
    }
}
