<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalMalfunctionSignCase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'external_malfunction_sign_case';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'case_id',
        'external_malfunction_sign_id',
    ];

    public function case()
    {
        return $this->belongsTo('app\Models\ECase');
    }

    public function external_malfunction_sign()
    {
        return $this->belongsTo('app\Models\ExternalMalfunctionSign');
    }
}
