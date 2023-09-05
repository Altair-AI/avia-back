<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationRuleMalfunctionCode extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation_rule_malfunction_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'malfunction_code_id',
        'operation_rule_id',
    ];

    public function malfunction_code()
    {
        return $this->belongsTo('app\Models\MalfunctionCode');
    }

    public function operation_rule()
    {
        return $this->belongsTo('app\Models\OperationRule');
    }
}
