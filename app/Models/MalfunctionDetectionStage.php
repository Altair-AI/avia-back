<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MalfunctionDetectionStage
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, ECase> $cases
 * @property-read int|null $cases_count
 * @method static Builder|MalfunctionDetectionStage newModelQuery()
 * @method static Builder|MalfunctionDetectionStage newQuery()
 * @method static Builder|MalfunctionDetectionStage query()
 * @method static Builder|MalfunctionDetectionStage whereCreatedAt($value)
 * @method static Builder|MalfunctionDetectionStage whereId($value)
 * @method static Builder|MalfunctionDetectionStage whereName($value)
 * @method static Builder|MalfunctionDetectionStage whereUpdatedAt($value)
 * @mixin Builder
 */
class MalfunctionDetectionStage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_detection_stage';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
    ];

    public function cases()
    {
        return $this->hasMany('app\Models\ECase', 'malfunction_detection_stage_id');
    }
}
