<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\TechnicalSystemOperation
 *
 * @property int $id
 * @property int $operation_id
 * @property int $technical_system_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Operation $operation
 * @property-read TechnicalSystem $technical_system
 * @method static Builder|TechnicalSystemDocument newModelQuery()
 * @method static Builder|TechnicalSystemDocument newQuery()
 * @method static Builder|TechnicalSystemDocument query()
 * @method static Builder|TechnicalSystemDocument whereCreatedAt($value)
 * @method static Builder|TechnicalSystemDocument whereId($value)
 * @method static Builder|TechnicalSystemDocument whereOperationId($value)
 * @method static Builder|TechnicalSystemDocument whereTechnicalSystemId($value)
 * @method static Builder|TechnicalSystemDocument whereUpdatedAt($value)
 * @mixin Builder
 */
class TechnicalSystemOperation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'technical_system_operation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'operation_id',
        'technical_system_id',
    ];

    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }

    public function technical_system()
    {
        return $this->belongsTo(TechnicalSystem::class);
    }
}
