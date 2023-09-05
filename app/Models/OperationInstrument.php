<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo('app\Models\Operation');
    }

    public function instrument()
    {
        return $this->belongsTo('app\Models\Instrument');
    }
}
