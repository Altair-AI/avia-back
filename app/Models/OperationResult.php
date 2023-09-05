<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationResult extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation_result';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function concrete_operation_results()
    {
        return $this->hasMany('app\Models\ConcreteOperationResult', 'operation_result_id');
    }

    public function completed_operations()
    {
        return $this->hasMany('app\Models\CompletedOperation', 'operation_result_id');
    }

    public function operation_rules()
    {
        return $this->hasMany('app\Models\OperationRule', 'operation_result_id');
    }
}
