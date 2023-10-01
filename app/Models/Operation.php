<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Operation
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
 * @property-read Collection<int, CompletedOperation> $completed_operations
 * @property-read int|null $completed_operations_count
 * @property-read Collection<int, ConcreteOperationCondition> $concrete_operation_conditions
 * @property-read int|null $concrete_operation_conditions_count
 * @property-read Collection<int, ConcreteOperationResult> $concrete_operation_results
 * @property-read int|null $concrete_operation_results_count
 * @property-read Document $document
 * @property-read Collection<int, CompletedOperation> $previous_completed_operations
 * @property-read int|null $previous_completed_operations_count
 * @method static Builder|Operation newModelQuery()
 * @method static Builder|Operation newQuery()
 * @method static Builder|Operation query()
 * @method static Builder|Operation whereCode($value)
 * @method static Builder|Operation whereCreatedAt($value)
 * @method static Builder|Operation whereDescription($value)
 * @method static Builder|Operation whereDocumentId($value)
 * @method static Builder|Operation whereDocumentIndicationNumber($value)
 * @method static Builder|Operation whereEndDocumentPage($value)
 * @method static Builder|Operation whereId($value)
 * @method static Builder|Operation whereImperativeName($value)
 * @method static Builder|Operation whereStartDocumentPage($value)
 * @method static Builder|Operation whereUpdatedAt($value)
 * @method static Builder|Operation whereVerbalName($value)
 * @mixin Builder
 */
class Operation extends Model
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
        'code',
        'imperative_name',
        'verbal_name',
        'description',
        'document_indication_number',
        'start_document_page',
        'end_document_page',
        'document_id',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function operation_instruments()
    {
        return $this->hasMany(OperationInstrument::class, 'operation_id');
    }

    public function concrete_operation_conditions()
    {
        return $this->hasMany(ConcreteOperationCondition::class, 'operation_id');
    }

    public function concrete_operation_results()
    {
        return $this->hasMany(ConcreteOperationResult::class, 'operation_id');
    }

    public function parent_operations()
    {
        return $this->hasMany(OperationHierarchy::class, 'parent_operation_id');
    }

    public function child_operations()
    {
        return $this->hasMany(OperationHierarchy::class, 'child_operation_id');
    }

    public function completed_operations()
    {
        return $this->hasMany(CompletedOperation::class, 'operation_id');
    }

    public function previous_completed_operations()
    {
        return $this->hasMany(CompletedOperation::class, 'previous_operation_id');
    }

    public function operation_rules_if()
    {
        return $this->hasMany(OperationRule::class, 'operation_id_if');
    }

    public function operation_rules_then()
    {
        return $this->hasMany(OperationRule::class, 'operation_id_then');
    }
}
