<?php namespace zgldh\ModuleUser;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionServiceProvider;
use zgldh\ModuleUser\Commands\SetupAdminUser;

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
        $this->app->register(PermissionServiceProvider::class);


        $this->app->singleton('zgldh.user.admin', function ($app) {
            return new SetupAdminUser();
        });

        $this->commands([
            'zgldh.user.admin'
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}