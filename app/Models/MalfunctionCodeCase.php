<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MalfunctionCodeCase
 *
 * @property int $id
 * @property int $case_id
 * @property int $malfunction_code_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ECase $case
 * @property-read MalfunctionCode $malfunction_code
 * @method static Builder|MalfunctionCodeCase newModelQuery()
 * @method static Builder|MalfunctionCodeCase newQuery()
 * @method static Builder|MalfunctionCodeCase query()
 * @method static Builder|MalfunctionCodeCase whereCaseId($value)
 * @method static Builder|MalfunctionCodeCase whereCreatedAt($value)
 * @method static Builder|MalfunctionCodeCase whereId($value)
 * @method static Builder|MalfunctionCodeCase whereMalfunctionCodeId($value)
 * @method static Builder|MalfunctionCodeCase whereUpdatedAt($value)
 * @mixin Builder
 */
class MalfunctionCodeCase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_code_case';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'case_id',
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

    public function case()
    {
        return $this->belongsTo(ECase::class);
    }

    public function malfunction_code()
    {
        return $this->belongsTo(MalfunctionCode::class);
    }
}
