<?php namespace zgldh\ModuleUser;

use Faker\Factory;
use Faker\Generator;
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
        $this->updateAuthConfig();
        $this->addAdminMenuItem($this->getModuleTemplateContent('menu.blade.php'));
        $this->copyLanguageFiles('module-user');
        $this->publicFactoryAndSeed(
            $this->getModuleTemplatePath('ModuleUserFactory.php'),
            $this->getModuleTemplatePath('ModuleUserSeed.php')
        );

        // Install laravel-permission
        App::register(PermissionServiceProvider::class);
        Artisan::call('vendor:publish', [
            '--provider' => PermissionServiceProvider::class,
            '--tag'      => 'migrations'
        ]);
        Artisan::call('vendor:publish', [
            '--provider' => PermissionServiceProvider::class,
            '--tag'      => 'config'
        ]);

        // Publish migrations
        $this->publishMigration('AddColumnsToUsersTable', __DIR__ . '/../migrations/add_columns_to_users_table.php');

        Artisan::call('migrate');

        $this->createBasicAdmin();

        exec('composer dumpautoload');
    }

    private function createBasicAdmin()
    {
        $ns = $this->moduleRootNamespace();
        $user = app($ns . '\User\Models\User');
        $user = $user->firstOrNew(['name' => 'admin']);
        $user->email = 'admin@email.com';
        $user->password = bcrypt('123456');
        $user->save();

        $role = app($ns . '\User\Models\Role');
        $role = $role->firstOrNew(['name' => 'super-admin']);
        $role->label = '超级管理员';
        $role->save();
        if (!$user->hasRole($role)) {
            $user->assignRole($role);
        }

        $permission = app($ns . '\User\Models\Permission');
        $permission = $permission->firstOrNew(['name' => 'can-manage-user']);
        $permission->label = $permission->label ?: '管理用户';
        $permission->save();
        if (!$role->hasPermissionTo($permission)) {
            $role->givePermissionTo($permission);
        }
    }

    private function updateAuthConfig()
    {
        $moduleRoot = $this->moduleRootNamespace();
        $replacement = ["'model' => App\User::class" => "'model' => {$moduleRoot}\User\Models\User::class"];
        Utils::replaceFilePlaceholders(config_path('auth.php'), $replacement, null, null);
    }
}