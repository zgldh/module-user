<?php namespace $NAME$\User\Repositories;

use $NAME$\User\Models\Role;
use zgldh\Scaffold\BaseRepository;

class RoleRepository extends BaseRepository
{
    const ROLE_ADMIN = 'admin';

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
        return Role::class;
    }
}
