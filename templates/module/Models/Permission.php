<?php namespace $NAME$\User\Models;

use Spatie\Permission\Models\Permission as BasePermission;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends BasePermission
{
    use LogsActivity;

    public $table = 'permissions';

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
