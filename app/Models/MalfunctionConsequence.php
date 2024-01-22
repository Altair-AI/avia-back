<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MalfunctionConsequence
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|MalfunctionConsequence newModelQuery()
 * @method static Builder|MalfunctionConsequence newQuery()
 * @method static Builder|MalfunctionConsequence query()
 * @method static Builder|MalfunctionConsequence whereCreatedAt($value)
 * @method static Builder|MalfunctionConsequence whereId($value)
 * @method static Builder|MalfunctionConsequence whereName($value)
 * @method static Builder|MalfunctionConsequence whereUpdatedAt($value)
 * @mixin Builder
 */
class MalfunctionConsequence extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_consequence';

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
        'created_at',
        'updated_at'
    ];

    public function malfunction_consequence_cases()
    {
        return $this->hasMany(MalfunctionConsequenceCase::class, 'malfunction_consequence_id');
    }
}
