<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\RealTimeTechnicalSystemUser
 *
 * @property int $id
 * @property int $real_time_technical_system_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read RealTimeTechnicalSystem $real_time_technical_system
 * @property-read User $user
 * @method static Builder|RealTimeTechnicalSystemUser newModelQuery()
 * @method static Builder|RealTimeTechnicalSystemUser newQuery()
 * @method static Builder|RealTimeTechnicalSystemUser query()
 * @method static Builder|RealTimeTechnicalSystemUser whereCreatedAt($value)
 * @method static Builder|RealTimeTechnicalSystemUser whereId($value)
 * @method static Builder|RealTimeTechnicalSystemUser whereRealTimeTechnicalSystemId($value)
 * @method static Builder|RealTimeTechnicalSystemUser whereUpdatedAt($value)
 * @method static Builder|RealTimeTechnicalSystemUser whereUserId($value)
 * @mixin Builder
 */
class RealTimeTechnicalSystemUser extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'real_time_technical_system_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'real_time_technical_system_id',
        'user_id',
    ];

    public function real_time_technical_system()
    {
        return $this->belongsTo(RealTimeTechnicalSystem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
