<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Organization
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $actual_address Фактический адрес организации
 * @property string|null $legal_address Юридический адрес организации
 * @property string|null $phone
 * @property string|null $tin ИНН/КПП
 * @property string|null $rboc ОКПО
 * @property string|null $psrn ОГРН
 * @property string|null $bank_account Банковский счет
 * @property string|null $bank_name Название банка
 * @property string|null $bik БИК
 * @property string|null $correspondent_account Корреспондентский счет
 * @property string|null $full_director_name
 * @property string|null $treaty_number Номер договора с организацией
 * @property string|null $treaty_date Дата договора с организацией
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, License> $licenses
 * @property-read int|null $licenses_count
 * @property-read Project $projects
 * @method static Builder|Organization newModelQuery()
 * @method static Builder|Organization newQuery()
 * @method static Builder|Organization query()
 * @method static Builder|Organization whereActualAddress($value)
 * @method static Builder|Organization whereBankAccount($value)
 * @method static Builder|Organization whereBankName($value)
 * @method static Builder|Organization whereBik($value)
 * @method static Builder|Organization whereCorrespondentAccount($value)
 * @method static Builder|Organization whereCreatedAt($value)
 * @method static Builder|Organization whereDescription($value)
 * @method static Builder|Organization whereFullDirectorName($value)
 * @method static Builder|Organization whereId($value)
 * @method static Builder|Organization whereLegalAddress($value)
 * @method static Builder|Organization whereName($value)
 * @method static Builder|Organization wherePhone($value)
 * @method static Builder|Organization wherePsrn($value)
 * @method static Builder|Organization whereRboc($value)
 * @method static Builder|Organization whereTin($value)
 * @method static Builder|Organization whereTreatyDate($value)
 * @method static Builder|Organization whereTreatyNumber($value)
 * @method static Builder|Organization whereUpdatedAt($value)
 * @mixin Builder
 */
class Organization extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'organization';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'actual_address',
        'legal_address',
        'tin',
        'rboc',
        'psrn',
        'phone',
        'bank_account',
        'bank_name',
        'bik',
        'correspondent_account',
        'full_director_name',
        'treaty_number',
        'treaty_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function licenses()
    {
        return $this->hasMany(License::class, 'organization_id');
    }

    /**
     * Получить все проекты, доступных организации.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'license',
            'organization_id', 'project_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'organization_id');
    }
}
