<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int $role
 * @property int $status
 * @property string|null $full_name
 * @property string $last_login_date
 * @property string $login_ip
 * @property int $organization_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, CaseBasedKnowledgeBase> $case_based_knowledge_bases
 * @property-read int|null $case_based_knowledge_bases_count
 * @property-read Collection<int, CompletedOperation> $completed_operations
 * @property-read int|null $completed_operations_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Organization $organization
 * @property-read Collection<int, RealTimeTechnicalSystemUser> $real_time_technical_system_users
 * @property-read int|null $real_time_technical_system_users_count
 * @property-read Collection<int, RuleBasedKnowledgeBase> $rule_based_knowledge_bases
 * @property-read int|null $rule_based_knowledge_bases_count
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFullName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastLoginDate($value)
 * @method static Builder|User whereLoginIp($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereOrganizationId($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRole($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Builder
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    // Роли пользователей
    const SUPER_ADMIN_ROLE = 0; // Супер-администратор (может все)
    const ADMIN_ROLE = 1;       // Администратор (занимается созданием и настройкой проектов)
    const TECHNICIAN_ROLE = 2;  // Техник (использует проекты)
    const GUEST_ROLE = 3;       // Гость (ничего не может, только просмотр определенной информации)

    // Статусы пользователей
    const ACTIVE_STATUS = 0;       // Авторизованный пользователь, который может взаимодействовать с системой
    const INACTIVE_STATUS = 1;     // Авторизованный пользователь, но который не может взаимодействовать с системой
    const NOT_VERIFIED_STATUS = 2; // Пользователь не прошедший до конца процедуру верификации при регистрации аккаунта

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'organization_id',
        'last_login_date',
        'login_ip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    public function real_time_technical_system_users()
    {
        return $this->hasMany('App\Models\RealTimeTechnicalSystemUser', 'user_id');
    }

    public function completed_operations()
    {
        return $this->hasMany('App\Models\CompletedOperation', 'user_id');
    }

    public function case_based_knowledge_bases()
    {
        return $this->hasMany('App\Models\CaseBasedKnowledgeBase', 'author');
    }

    public function rule_based_knowledge_bases()
    {
        return $this->hasMany('App\Models\RuleBasedKnowledgeBase', 'author');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
