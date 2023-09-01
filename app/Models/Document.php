<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'document';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'code',
        'name',
        'type',
        'version',
        'file',
    ];

    public function technical_system_documents()
    {
        return $this->hasMany('app\Models\TechnicalSystemDocument', 'document_id');
    }

    public function operations()
    {
        return $this->hasMany('app\Models\Operation', 'document_id');
    }

    public function malfunction_cause_rules()
    {
        return $this->hasMany('app\Models\MalfunctionCauseRule', 'document_id');
    }

    public function operation_rules()
    {
        return $this->hasMany('app\Models\OperationRule', 'document_id');
    }
}
