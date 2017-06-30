<?php namespace $NAME$\User\Repositories;

use $NAME$\User\Models\Permission;
use zgldh\Scaffold\BaseRepository;

class PermissionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'label'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Permission::class;
    }
}
