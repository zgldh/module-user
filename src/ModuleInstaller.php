<?php namespace zgldh\ModuleUser;

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
    }
}