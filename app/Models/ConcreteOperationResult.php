<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConcreteOperationResult extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'concrete_operation_result';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'operation_id',
        'operation_result_id',
    ];

    public function operation()
    {
        return $this->belongsTo('app\Models\Operation');
    }

    public function operation_result()
    {
        return $this->belongsTo('app\Models\OperationResult');
    }
}
