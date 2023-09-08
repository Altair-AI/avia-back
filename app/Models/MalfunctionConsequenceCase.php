<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MalfunctionConsequenceCase
 *
 * @property int $id
 * @property int $case_id
 * @property int $malfunction_consequence_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ECase $case
 * @property-read MalfunctionConsequence $malfunction_consequence
 * @method static Builder|MalfunctionConsequenceCase newModelQuery()
 * @method static Builder|MalfunctionConsequenceCase newQuery()
 * @method static Builder|MalfunctionConsequenceCase query()
 * @method static Builder|MalfunctionConsequenceCase whereCaseId($value)
 * @method static Builder|MalfunctionConsequenceCase whereCreatedAt($value)
 * @method static Builder|MalfunctionConsequenceCase whereId($value)
 * @method static Builder|MalfunctionConsequenceCase whereMalfunctionConsequenceId($value)
 * @method static Builder|MalfunctionConsequenceCase whereUpdatedAt($value)
 * @mixin Builder
 */
class MalfunctionConsequenceCase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_consequence_case';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'case_id',
        'malfunction_consequence_id',
    ];

    public function case()
    {
        return $this->belongsTo('App\Models\ECase');
    }

    public function malfunction_consequence()
    {
        return $this->belongsTo('App\Models\MalfunctionConsequence');
    }
}
