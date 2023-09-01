<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseBasedKnowledgeBase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'case_based_knowledge_base';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'correctness',
        'author',
        'real_time_technical_system_id',
        'project_id',
    ];

    public function author()
    {
        return $this->belongsTo('app\Models\User');
    }

    public function real_time_technical_system()
    {
        return $this->belongsTo('app\Models\RealTimeTechnicalSystem');
    }

    public function project()
    {
        return $this->belongsTo('app\Models\Project');
    }

    public function cases()
    {
        return $this->hasMany('app\Models\ECase', 'case_based_knowledge_base_id');
    }
}
