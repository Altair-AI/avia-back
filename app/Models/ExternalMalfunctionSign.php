<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalMalfunctionSign extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'external_malfunction_sign';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
    ];

    public function external_malfunction_sign_cases()
    {
        return $this->hasMany('app\Models\ExternalMalfunctionSignCase', 'external_malfunction_sign_id');
    }
}
