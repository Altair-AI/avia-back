<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

/**
 * App\Models\MalfunctionCode
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property string $source
 * @property string $alternative_name
 * @property int $technical_system_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, MalfunctionCauseRuleIf> $malfunction_cause_rules_if
 * @property-read int|null $malfunction_cause_rules_if_count
 * @property-read MalfunctionCauseRule $malfunction_cause_rules
 * @property-read Operation $operations
 * @property-read TechnicalSystem $technical_system
 * @method static Builder|MalfunctionCode newModelQuery()
 * @method static Builder|MalfunctionCode newQuery()
 * @method static Builder|MalfunctionCode query()
 * @method static Builder|MalfunctionCode whereAlternativeName($value)
 * @method static Builder|MalfunctionCode whereCreatedAt($value)
 * @method static Builder|MalfunctionCode whereId($value)
 * @method static Builder|MalfunctionCode whereName($value)
 * @method static Builder|MalfunctionCode whereSource($value)
 * @method static Builder|MalfunctionCode whereTechnicalSystemId($value)
 * @method static Builder|MalfunctionCode whereType($value)
 * @method static Builder|MalfunctionCode whereUpdatedAt($value)
 * @mixin Builder
 */
class MalfunctionCode extends Model
{
    use HasFactory, Filterable;

    // Типы кодов неисправностей
    const EMRG_TYPE = 0;  // Аварийно‐сигнальное сообщение
    const BSTO_TYPE = 1;  // Сообщение БСТО
    const SEI_TYPE = 2;   // Сигнализация СЭИ
    const LOCAL_TYPE = 3; // Локальная сигнализация
    const OBS_TYPE = 4;   // Наблюдаемые неисправности

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malfunction_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'type',
        'source',
        'alternative_name',
        'technical_system_id'
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

    /**
     * Get a list of types.
     *
     * @return string[]
     */
    public static function getTypeArray()
    {
        return [
            self::EMRG_TYPE => 'Аварийно‐сигнальное сообщение',
            self::BSTO_TYPE => 'Сообщение БСТО',
            self::SEI_TYPE => 'Сигнализация СЭИ',
            self::LOCAL_TYPE => 'Локальная сигнализация',
            self::OBS_TYPE => 'Наблюдаемые неисправности'
        ];
    }

    /**
     * Get a type name.
     *
     * @param $type
     * @return array|\ArrayAccess|mixed
     */
    public static function getTypeName($type)
    {
        return Arr::get(self::getTypeArray(), $type);
    }

    public function technical_system()
    {
        return $this->belongsTo(TechnicalSystem::class);
    }

    public function malfunction_code_cases()
    {
        return $this->hasMany(MalfunctionCodeCase::class, 'malfunction_code_id');
    }

    public function malfunction_cause_rules_if()
    {
        return $this->hasMany(MalfunctionCauseRuleIf::class, 'malfunction_code_id');
    }

    /**
     * Получить все правила определения причины неисправности соответствующие данному коду (признаку) неисправности.
     */
    public function malfunction_cause_rules()
    {
        return $this->belongsToMany(MalfunctionCauseRule::class, 'malfunction_cause_rule_if',
            'malfunction_code_id', 'malfunction_cause_rule_id');
    }

    public function operation_rule_malfunction_codes()
    {
        return $this->hasMany(OperationRuleMalfunctionCode::class, 'malfunction_code_id');
    }

    public function operation_malfunction_codes()
    {
        return $this->hasMany(OperationMalfunctionCode::class, 'malfunction_code_id');
    }

    /**
     * Получить все работы (операции) соответствующие данному коду (признаку) неисправности.
     */
    public function operations()
    {
        return $this->belongsToMany(Operation::class, 'operation_malfunction_code',
            'malfunction_code_id', 'operation_id');
    }
}
