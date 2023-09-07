<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\OperationHierarchy
 *
 * @property int $id
 * @property string $code
 * @property string $imperative_name
 * @property string $verbal_name
 * @property string|null $description
 * @property string $document_indication_number
 * @property int $start_document_page
 * @property int $end_document_page
 * @property int $document_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Operation|null $child_operation
 * @property-read Operation|null $parent_operation
 * @method static Builder|OperationHierarchy newModelQuery()
 * @method static Builder|OperationHierarchy newQuery()
 * @method static Builder|OperationHierarchy query()
 * @method static Builder|OperationHierarchy whereCode($value)
 * @method static Builder|OperationHierarchy whereCreatedAt($value)
 * @method static Builder|OperationHierarchy whereDescription($value)
 * @method static Builder|OperationHierarchy whereDocumentId($value)
 * @method static Builder|OperationHierarchy whereDocumentIndicationNumber($value)
 * @method static Builder|OperationHierarchy whereEndDocumentPage($value)
 * @method static Builder|OperationHierarchy whereId($value)
 * @method static Builder|OperationHierarchy whereImperativeName($value)
 * @method static Builder|OperationHierarchy whereStartDocumentPage($value)
 * @method static Builder|OperationHierarchy whereUpdatedAt($value)
 * @method static Builder|OperationHierarchy whereVerbalName($value)
 * @mixin Builder
 */
class OperationHierarchy extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'parent_operation_id',
        'child_operation_id',
    ];

    public function parent_operation()
    {
        return $this->belongsTo('app\Models\Operation');
    }

    public function child_operation()
    {
        return $this->belongsTo('app\Models\Operation');
    }
}
