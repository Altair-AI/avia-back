<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealTimeTechnicalSystemUser extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'real_time_technical_system_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'real_time_technical_system_id',
        'user_id',
    ];

    public function real_time_technical_system()
    {
        return $this->belongsTo('app\Models\RealTimeTechnicalSystem');
    }

    public function user()
    {
        return $this->belongsTo('app\Models\User');
    }
}
