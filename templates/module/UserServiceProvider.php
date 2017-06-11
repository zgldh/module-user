<?php namespace $NAME$\User;

class UserServiceProvider extends \zgldh\ModuleUser\UserServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadViewsFrom(__DIR__ . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . 'views',
            '$NAME$\User');
    }
}