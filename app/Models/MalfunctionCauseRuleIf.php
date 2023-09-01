<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MalfunctionCauseRuleIf extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_cause_rule_if';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'malfunction_cause_rule_id',
        'malfunction_code_id',
    ];

    public function malfunction_cause_rule()
    {
        return $this->belongsTo('app\Models\MalfunctionCauseRule');
    }

    public function malfunction_code()
    {
        return $this->belongsTo('app\Models\MalfunctionCode');
    }
}
