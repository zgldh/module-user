<?php namespace $NAME$\User;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;

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
        parent::register();
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

        \Event::listen(Login::class, function (Login $event) {
            $user = $event->user;
            $user->last_login_at = Carbon::now();
            $user->login_times++;
            $user->save();
        });
    }
}