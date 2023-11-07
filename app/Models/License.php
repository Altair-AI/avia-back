<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\License
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $description
 * @property string $start_date
 * @property string $end_date
 * @property int $type
 * @property int $organization_id
 * @property int $project_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Organization $organization
 * @property-read Project $project
 * @method static Builder|License newModelQuery()
 * @method static Builder|License newQuery()
 * @method static Builder|License query()
 * @method static Builder|License whereCode($value)
 * @method static Builder|License whereCreatedAt($value)
 * @method static Builder|License whereDescription($value)
 * @method static Builder|License whereEndDate($value)
 * @method static Builder|License whereId($value)
 * @method static Builder|License whereName($value)
 * @method static Builder|License whereOrganizationId($value)
 * @method static Builder|License whereProjectId($value)
 * @method static Builder|License whereStartDate($value)
 * @method static Builder|License whereType($value)
 * @method static Builder|License whereUpdatedAt($value)
 * @mixin Builder
 */
class License extends Model
{
    use HasFactory;

    // Типы лицензий
    const BASE_TYPE = 0;  // Базовый (основной тариф)
    const LOYALTY_TYPE = 1; // Лояльный (тариф для постоянных клиентов)
    const PROMO_TYPE = 1; // Промо (тариф по акции)

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'license';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'start_date',
        'end_date',
        'type',
        'organization_id',
        'project_id',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
