<?php namespace $NAME$\User\Models;

use Spatie\Permission\Models\Role as BaseRole;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends BaseRole
{
    use LogsActivity;

    public $table = 'roles';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'name',
        'label',
    ];

    protected static $logAttributes = [
        'name',
        'label',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'    => 'integer',
        'name'  => 'string',
        'label' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'  => 'required',
        'label' => 'required'
    ];
}
