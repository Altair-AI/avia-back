<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OperationInstrument
 *
 * @property int $id
 * @property int $operation_id
 * @property int $instrument_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Instrument $instrument
 * @property-read Operation $operation
 * @method static Builder|OperationInstrument newModelQuery()
 * @method static Builder|OperationInstrument newQuery()
 * @method static Builder|OperationInstrument query()
 * @method static Builder|OperationInstrument whereCreatedAt($value)
 * @method static Builder|OperationInstrument whereId($value)
 * @method static Builder|OperationInstrument whereInstrumentId($value)
 * @method static Builder|OperationInstrument whereOperationId($value)
 * @method static Builder|OperationInstrument whereUpdatedAt($value)
 * @mixin Builder
 */
class OperationInstrument extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation_instrument';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'operation_id',
        'instrument_id',
    ];

    public function operation()
    {
        return $this->belongsTo('App\Models\Operation');
    }

    public function instrument()
    {
        return $this->belongsTo('App\Models\Instrument');
    }
}
