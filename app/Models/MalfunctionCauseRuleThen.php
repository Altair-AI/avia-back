<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MalfunctionCauseRuleThen extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_cause_rule_then';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'malfunction_cause_rule_id',
        'technical_system_id',
    ];

    public function malfunction_cause_rule()
    {
        return $this->belongsTo('app\Models\MalfunctionCauseRule');
    }

    public function technical_system()
    {
        return $this->belongsTo('app\Models\TechnicalSystem');
    }
}
