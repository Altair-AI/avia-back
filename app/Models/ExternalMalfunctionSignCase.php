<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ExternalMalfunctionSignCase
 *
 * @property int $id
 * @property int $case_id
 * @property int $external_malfunction_sign_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ECase $case
 * @property-read ExternalMalfunctionSign $external_malfunction_sign
 * @method static Builder|ExternalMalfunctionSignCase newModelQuery()
 * @method static Builder|ExternalMalfunctionSignCase newQuery()
 * @method static Builder|ExternalMalfunctionSignCase query()
 * @method static Builder|ExternalMalfunctionSignCase whereCaseId($value)
 * @method static Builder|ExternalMalfunctionSignCase whereCreatedAt($value)
 * @method static Builder|ExternalMalfunctionSignCase whereExternalMalfunctionSignId($value)
 * @method static Builder|ExternalMalfunctionSignCase whereId($value)
 * @method static Builder|ExternalMalfunctionSignCase whereUpdatedAt($value)
 * @mixin Builder
 */
class ExternalMalfunctionSignCase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'external_malfunction_sign_case';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'case_id',
        'external_malfunction_sign_id',
    ];

    public function case()
    {
        return $this->belongsTo('App\Models\ECase');
    }

    public function external_malfunction_sign()
    {
        return $this->belongsTo('App\Models\ExternalMalfunctionSign');
    }
}
