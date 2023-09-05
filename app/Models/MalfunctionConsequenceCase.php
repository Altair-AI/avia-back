<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MalfunctionConsequenceCase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_consequence_case';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'case_id',
        'malfunction_consequence_id',
    ];

    public function case()
    {
        return $this->belongsTo('app\Models\ECase');
    }

    public function malfunction_consequence()
    {
        return $this->belongsTo('app\Models\MalfunctionConsequence');
    }
}
