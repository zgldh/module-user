<?php namespace $NAME$\User\Repositories;

use $NAME$\User\Models\User;
use zgldh\Scaffold\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'password',
        'remember_token'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function create(array $attributes)
    {
        $attributes['password'] = bcrypt($attributes['password']);
        return parent::create($attributes);
    }

    public function update(array $attributes, $id)
    {
        if (isset($attributes['password']) && strlen($attributes['password']) > 0) {
            $attributes['password'] = bcrypt($attributes['password']);
        } else {
            unset($attributes['password']);
        }
        return parent::update($attributes, $id);
    }
}
