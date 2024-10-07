<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ActionLog
 *
 * @property int $id
 * @property Carbon $datetime
 * @property string $description
 * @property string $client_ip
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder|ActionLog newModelQuery()
 * @method static Builder|ActionLog newQuery()
 * @method static Builder|ActionLog query()
 * @method static Builder|ActionLog whereClientIp($value)
 * @method static Builder|ActionLog whereCreatedAt($value)
 * @method static Builder|ActionLog whereDatetime($value)
 * @method static Builder|ActionLog whereDescription($value)
 * @method static Builder|ActionLog whereId($value)
 * @method static Builder|ActionLog whereUpdatedAt($value)
 * @method static Builder|ActionLog whereUserId($value)
 * @mixin Builder
 */
class ActionLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'action_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'datetime',
        'description',
        'client_ip',
        'user_id'
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
