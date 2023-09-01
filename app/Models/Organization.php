<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'organization';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'actual_address',
        'legal_address',
        'tin',
        'rboc',
        'psrn',
        'phone',
        'bank_account',
        'bank_name',
        'bik',
        'correspondent_account',
        'full_director_name',
        'treaty_number',
        'treaty_date',
    ];

    public function licenses()
    {
        return $this->hasMany('app\Models\License', 'organization_id');
    }

    public function users()
    {
        return $this->hasMany('app\Models\User', 'organization_id');
    }
}
