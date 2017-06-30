<?php namespace zgldh\ModuleUser;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\PermissionServiceProvider;
use zgldh\Scaffold\Installer\ModuleInstaller as BaseInstaller;
use zgldh\Scaffold\Installer\Utils;

/**
 * Created by PhpStorm.
 * User: zhangwb-pc
 * Date: 11/14/2016
 * Time: 2:00 PM
 */
class ModuleInstaller extends BaseInstaller
{
    public function __construct()
    {
        parent::__construct();
        $this->moduleTemplatePath = __DIR__ . '/../templates/';
    }

    public function run()
    {
        $this->copyModuleFilesTo('User');

        $this->addServiceProvider('User', 'UserServiceProvider::class');
        $this->addRoute('User');
        $this->addToVueRoute('User');
        Utils::addAdminMenuItem($this->getModuleTemplateContent('menu.blade.php'));

        // Install laravel-permission
        App::register(PermissionServiceProvider::class);
        Artisan::call('vendor:publish', [
            '--provider' => PermissionServiceProvider::class,
            '--tag'      => 'migrations']);
        Artisan::call('vendor:publish', [
            '--provider' => PermissionServiceProvider::class,
            '--tag'      => 'config']);

        // Publish migrations
        $this->publishMigration('UpdatePermissionsTables', __DIR__ . '/../migrations/add_columns_to_users_table.php');

        Artisan::call('migrate');
        exec('composer dumpautoload');
    }
}