<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MalfunctionCauseRuleThen
 *
 * @property int $id
 * @property int $malfunction_cause_rule_id
 * @property int $technical_system_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MalfunctionCauseRule $malfunction_cause_rule
 * @method static Builder|MalfunctionCauseRuleThen newModelQuery()
 * @method static Builder|MalfunctionCauseRuleThen newQuery()
 * @method static Builder|MalfunctionCauseRuleThen query()
 * @method static Builder|MalfunctionCauseRuleThen whereCreatedAt($value)
 * @method static Builder|MalfunctionCauseRuleThen whereId($value)
 * @method static Builder|MalfunctionCauseRuleThen whereMalfunctionCauseRuleId($value)
 * @method static Builder|MalfunctionCauseRuleThen whereTechnicalSystemId($value)
 * @method static Builder|MalfunctionCauseRuleThen whereUpdatedAt($value)
 * @mixin Builder
 */
class MalfunctionCauseRuleThen extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_cause_rule_then';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'malfunction_cause_rule_id',
        'technical_system_id',
    ];

    public function malfunction_cause_rule()
    {
        return $this->belongsTo('App\Models\MalfunctionCauseRule');
    }

    public function technical_system()
    {
        return $this->belongsTo('App\Models\TechnicalSystem');
    }
}
