<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Instrument
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Instrument newModelQuery()
 * @method static Builder|Instrument newQuery()
 * @method static Builder|Instrument query()
 * @method static Builder|Instrument whereCreatedAt($value)
 * @method static Builder|Instrument whereDescription($value)
 * @method static Builder|Instrument whereId($value)
 * @method static Builder|Instrument whereName($value)
 * @method static Builder|Instrument whereUpdatedAt($value)
 * @mixin Builder
 */
class Instrument extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'instrument';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function operation_instruments()
    {
        return $this->hasMany('app\Models\OperationInstrument', 'instrument_id');
    }
}
