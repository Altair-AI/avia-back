<?php
namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        return $this->belongsTo('app\Models\Organization');
    }

    public function real_time_technical_system_users()
    {
        return $this->hasMany('app\Models\RealTimeTechnicalSystemUser', 'user_id');
    }

    public function completed_operations()
    {
        return $this->hasMany('app\Models\CompletedOperation', 'user_id');
    }

    public function case_based_knowledge_bases()
    {
        return $this->hasMany('app\Models\CaseBasedKnowledgeBase', 'author');
    }

    public function rule_based_knowledge_bases()
    {
        return $this->hasMany('app\Models\RuleBasedKnowledgeBase', 'author');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }
}
