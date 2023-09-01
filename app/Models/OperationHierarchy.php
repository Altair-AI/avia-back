<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationHierarchy extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'parent_operation_id',
        'child_operation_id',
    ];

    public function parent_operation()
    {
        return $this->belongsTo('app\Models\Operation');
    }

    public function child_operation()
    {
        return $this->belongsTo('app\Models\Operation');
    }
}
