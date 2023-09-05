<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MalfunctionCodeCase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_code_case';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'case_id',
        'malfunction_code_id',
    ];

    public function case()
    {
        return $this->belongsTo('app\Models\ECase');
    }

    public function malfunction_code()
    {
        return $this->belongsTo('app\Models\MalfunctionCode');
    }
}
