<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealTimeTechnicalSystem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'real_time_technical_system';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'registration_code',
        'registration_description',
        'operation_time_from_start',
        'operation_time_from_last_repair',
        'technical_system_id',
        'project_id',
    ];

    public function technical_system()
    {
        return $this->belongsTo('app\Models\TechnicalSystem');
    }

    public function project()
    {
        return $this->belongsTo('app\Models\Project');
    }

    public function real_time_technical_system_users()
    {
        return $this->hasMany('app\Models\RealTimeTechnicalSystemUser', 'real_time_technical_system_id');
    }

    public function case_based_knowledge_bases()
    {
        return $this->hasMany('app\Models\CaseBasedKnowledgeBase', 'real_time_technical_system_id');
    }

    public function malfunction_system_cases()
    {
        return $this->hasMany('app\Models\ECase', 'malfunction_system_id');
    }

    public function system_for_repair_cases()
    {
        return $this->hasMany('app\Models\ECase', 'system_id_for_repair');
    }
}
