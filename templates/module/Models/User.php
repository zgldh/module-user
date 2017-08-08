<?php namespace $NAME$\User\Models;

use $NAME$\Upload\Models\Upload;
use $NAME$\User\Repositories\RoleRepository;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use zgldh\ModuleUpload\Traits\HasUploads;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;
    use HasUploads;
    use SoftDeletes;

    public $table = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    const ACTIVE = 1;
    const INACTIVE = 0;

    public $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'mobile',
        'is_active',
        'last_login_at',
        'login_times',
        'avatar_id'
    ];

    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'name'          => 'string',
        'email'         => 'string',
        'is_active'     => 'integer',
        'last_login_at' => 'datetime',
        'login_times'   => 'integer',
        'avatar_id'   => 'integer',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'     => 'required',
        'password' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_has_permissions');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_has_roles');
    }

    public function avatar()
    {
        return $this->belongsTo(Upload::class, 'avatar_id', 'id');
    }

    public function isAdmin()
    {
        return $this->hasRole(RoleRepository::ROLE_SUPER_ADMIN);
    }
}
