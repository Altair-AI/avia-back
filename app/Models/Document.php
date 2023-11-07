<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Document
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $type
 * @property string $version
 * @property string|null $file
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read TechnicalSystem $technical_systems
 * @method static Builder|Document newModelQuery()
 * @method static Builder|Document newQuery()
 * @method static Builder|Document query()
 * @method static Builder|Document whereCode($value)
 * @method static Builder|Document whereCreatedAt($value)
 * @method static Builder|Document whereFile($value)
 * @method static Builder|Document whereId($value)
 * @method static Builder|Document whereName($value)
 * @method static Builder|Document whereType($value)
 * @method static Builder|Document whereUpdatedAt($value)
 * @method static Builder|Document whereVersion($value)
 * @mixin Builder
 */
class Document extends Model
{
    use HasFactory;

    // Типы технических документов
    const TROUBLESHOOTING_GUIDE_TYPE = 0; // РУН (руководство по устранению неисправности)
    const MAINTENANCE_GUIDE_TYPE = 1;     // РЭ (руководство по эксплуатации)

    protected $hidden = ['pivot'];

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
        return $this->hasMany(TechnicalSystemDocument::class, 'document_id');
    }

    /**
     * Получить все технические системы к которым относится данный документ.
     */
    public function technical_systems()
    {
        return $this->belongsToMany(TechnicalSystem::class, 'technical_system_document',
            'document_id', 'technical_system_id');
    }

    public function operations()
    {
        return $this->hasMany(Operation::class, 'document_id');
    }

    public function malfunction_cause_rules()
    {
        return $this->hasMany(MalfunctionCauseRule::class, 'document_id');
    }

    public function operation_rules()
    {
        return $this->hasMany(OperationRule::class, 'document_id');
    }
}
