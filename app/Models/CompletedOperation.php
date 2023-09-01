<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedOperation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'completed_operation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'type',
        'operation_id',
        'previous_operation_id',
        'operation_result_id',
        'user_id',
    ];

    public function operation()
    {
        return $this->belongsTo('app\Models\Operation');
    }

    public function previous_operation()
    {
        return $this->belongsTo('app\Models\Operation');
    }

    public function operation_result()
    {
        return $this->belongsTo('app\Models\OperationResult');
    }

    public function user()
    {
        return $this->belongsTo('app\Models\User');
    }

    public function cases()
    {
        return $this->hasMany('app\Models\ECase', 'initial_completed_operation_id');
    }
}
