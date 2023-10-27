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
 * @method static Builder|TechnicalSystemOperation newModelQuery()
 * @method static Builder|TechnicalSystemOperation newQuery()
 * @method static Builder|TechnicalSystemOperation query()
 * @method static Builder|TechnicalSystemOperation whereCreatedAt($value)
 * @method static Builder|TechnicalSystemOperation whereId($value)
 * @method static Builder|TechnicalSystemOperation whereOperationId($value)
 * @method static Builder|TechnicalSystemOperation whereTechnicalSystemId($value)
 * @method static Builder|TechnicalSystemOperation whereUpdatedAt($value)
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
