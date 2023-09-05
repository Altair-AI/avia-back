<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSystemDocument extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'technical_system_document';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'document_id',
        'technical_system_id',
    ];

    public function document()
    {
        return $this->belongsTo('app\Models\Document');
    }

    public function technical_system()
    {
        return $this->belongsTo('app\Models\TechnicalSystem');
    }
}
