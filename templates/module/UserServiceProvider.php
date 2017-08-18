<?php namespace $NAME$\User;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use $NAME$\ActionLog\Models\ActionLog;
use $NAME$\ActionLog\Repositories\ActionLogRepository;

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
        parent::boot();
        $this->loadViewsFrom(__DIR__ . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . 'views',
            '$NAME$\User');

        \Event::listen(Login::class, function (Login $event) {
            $user = $event->user;
            $user->last_login_at = Carbon::now();
            $user->login_times++;
            $user->save();

            ActionLogRepository::log(ActionLog::TYPE_LOGIN, 'user', $user);
        });

        \Event::listen(Logout::class, function (Logout $event) {
            $user = $event->user;
            ActionLogRepository::log(ActionLog::TYPE_LOGOUT, 'user', $user);
        });
    }
}