<?php namespace zgldh\ModuleUser;

use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: zhangwb-pc
 * Date: 11/14/2016
 * Time: 2:00 PM
 */
class UserServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }
}