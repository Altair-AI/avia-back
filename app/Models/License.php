<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'license';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'start_date',
        'end_date',
        'type',
        'organization_id',
        'project_id',
    ];

    public function organization()
    {
        return $this->belongsTo('app\Models\Organization');
    }

    public function project()
    {
        return $this->belongsTo('app\Models\Project');
    }
}
