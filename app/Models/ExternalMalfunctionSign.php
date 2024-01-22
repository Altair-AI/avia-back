<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ExternalMalfunctionSign
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ExternalMalfunctionSign newModelQuery()
 * @method static Builder|ExternalMalfunctionSign newQuery()
 * @method static Builder|ExternalMalfunctionSign query()
 * @method static Builder|ExternalMalfunctionSign whereCreatedAt($value)
 * @method static Builder|ExternalMalfunctionSign whereId($value)
 * @method static Builder|ExternalMalfunctionSign whereName($value)
 * @method static Builder|ExternalMalfunctionSign whereUpdatedAt($value)
 * @mixin Builder
 */
class ExternalMalfunctionSign extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'external_malfunction_sign';

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

    public function external_malfunction_sign_cases()
    {
        return $this->hasMany(ExternalMalfunctionSignCase::class, 'external_malfunction_sign_id');
    }
}
