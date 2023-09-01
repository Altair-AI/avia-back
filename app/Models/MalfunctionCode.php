<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MalfunctionCode extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'type',
        'technical_system_id',
    ];

    public function technical_system()
    {
        return $this->belongsTo('app\Models\TechnicalSystem');
    }

    public function malfunction_code_cases()
    {
        return $this->hasMany('app\Models\MalfunctionCodeCase', 'malfunction_code_id');
    }

    public function malfunction_cause_rules_if()
    {
        return $this->hasMany('app\Models\MalfunctionCauseRuleIf', 'malfunction_code_id');
    }

    public function operation_rule_malfunction_codes()
    {
        return $this->hasMany('app\Models\OperationRuleMalfunctionCode', 'malfunction_code_id');
    }
}
