<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
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
        'code',
        'imperative_name',
        'verbal_name',
        'description',
        'document_indication_number',
        'start_document_page',
        'end_document_page',
        'document_id',
    ];

    public function document()
    {
        return $this->belongsTo('app\Models\Document');
    }

    public function operation_instruments()
    {
        return $this->hasMany('app\Models\OperationInstrument', 'operation_id');
    }

    public function concrete_operation_conditions()
    {
        return $this->hasMany('app\Models\ConcreteOperationCondition', 'operation_id');
    }

    public function concrete_operation_results()
    {
        return $this->hasMany('app\Models\ConcreteOperationResult', 'operation_id');
    }

    public function parent_operations()
    {
        return $this->hasMany('app\Models\OperationHierarchy', 'parent_operation_id');
    }

    public function child_operations()
    {
        return $this->hasMany('app\Models\OperationHierarchy', 'child_operation_id');
    }

    public function completed_operations()
    {
        return $this->hasMany('app\Models\CompletedOperation', 'operation_id');
    }

    public function previous_completed_operations()
    {
        return $this->hasMany('app\Models\CompletedOperation', 'previous_operation_id');
    }

    public function operation_rules_if()
    {
        return $this->hasMany('app\Models\OperationRule', 'operation_id_if');
    }

    public function operation_rules_then()
    {
        return $this->hasMany('app\Models\OperationRule', 'operation_id_then');
    }
}
