<?php

namespace App\Models;

use App\Models\Traits\Filterable;
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
 * @property int $type
 * @property string $imperative_name
 * @property string $verbal_name
 * @property string|null $description
 * @property string $document_section
 * @property string $document_subsection
 * @property int $start_document_page
 * @property int|null $end_document_page
 * @property int|null $actual_document_page
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
 * @property-read Collection<int, ExecutionRule> $execution_rules
 * @property-read int|null $execution_rules_count
 * @property-read MalfunctionCode malfunction_codes
 * @property-read Operation $operations
 * @property-read OperationResult $operation_results
 * @property-read Operation $sub_operations
 * @property-read TechnicalSystem $technical_systems
 * @method static Builder|Operation newModelQuery()
 * @method static Builder|Operation newQuery()
 * @method static Builder|Operation query()
 * @method static Builder|Operation whereActualDocumentPage($value)
 * @method static Builder|Operation whereCode($value)
 * @method static Builder|Operation whereCreatedAt($value)
 * @method static Builder|Operation whereDescription($value)
 * @method static Builder|Operation whereDocumentId($value)
 * @method static Builder|Operation whereDocumentSection($value)
 * @method static Builder|Operation whereDocumentSubSection($value)
 * @method static Builder|Operation whereEndDocumentPage($value)
 * @method static Builder|Operation whereId($value)
 * @method static Builder|Operation whereImperativeName($value)
 * @method static Builder|Operation whereStartDocumentPage($value)
 * @method static Builder|Operation whereType($value)
 * @method static Builder|Operation whereUpdatedAt($value)
 * @method static Builder|Operation whereVerbalName($value)
 * @mixin Builder
 */
class Operation extends Model
{
    use HasFactory, Filterable;

    // Типы работ (операций)
    const BASIC_OPERATION_TYPE = 0;  // Основная работа
    const NESTED_OPERATION_TYPE = 1; // Вложенная подработа

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
        'type',
        'imperative_name',
        'verbal_name',
        'description',
        'document_section',
        'document_subsection',
        'start_document_page',
        'end_document_page',
        'actual_document_page',
        'document_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<string>
     */
    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function technical_system_operations()
    {
        return $this->hasMany(TechnicalSystemOperation::class, 'operation_id');
    }

    /**
     * Получить все технические системы на которые направлена данная работа (операция).
     */
    public function technical_systems()
    {
        return $this->belongsToMany(TechnicalSystem::class, 'technical_system_operation',
            'operation_id', 'technical_system_id');
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

    /**
     * Получить все результаты данной работы (операции).
     */
    public function operation_results()
    {
        return $this->belongsToMany(OperationResult::class, 'concrete_operation_result',
            'operation_id', 'operation_result_id');
    }

    public function parent_operations()
    {
        return $this->hasMany(OperationHierarchy::class, 'parent_operation_id');
    }

    public function child_operations()
    {
        return $this->hasMany(OperationHierarchy::class, 'child_operation_id');
    }

    /**
     * Получить все подработы (подопераций) для текущей работы.
     */
    public function operations()
    {
        return $this->belongsToMany(Operation::class, 'operation_hierarchy',
            'parent_operation_id', 'child_operation_id');
    }

    /**
     * Возвращает всю иерархию подработ (подопераций) для текущей работы.
     */
    public function sub_operations()
    {
        return $this->operations()->with('sub_operations');
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

    public function operation_malfunction_codes()
    {
        return $this->hasMany(OperationMalfunctionCode::class, 'operation_id');
    }

    /**
     * Получить все коды (признаки) неисправностей соответствующие данной работе (операции).
     */
    public function malfunction_codes()
    {
        return $this->belongsToMany(MalfunctionCode::class, 'operation_malfunction_code',
            'operation_id', 'malfunction_code_id');
    }

    public function execution_rules()
    {
        return $this->hasMany(ExecutionRule::class, 'operation_id');
    }
}
