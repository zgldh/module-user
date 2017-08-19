# module-user
User Module for zgldh/scaffold 

## 安装
1. 执行 `composer require zgldh/module-user`
2. 安装依赖包  `zgldh:module:install zgldh\ModuleActivityLog`
2. 安装依赖包  `zgldh:module:install zgldh\ModuleUpload`
3. 执行  `php artisan zgldh:module:install zgldh\ModuleUser`
    1. 自动将文件放入 Modules 目录下
    2. 自动设置好 `/database` 目录
    3. 自动设置好 `/config/app.php` 加入对应的 ServiceProvider
    4. 自动执行 `php artisan migrate`
    
## 测试数据
1. 执行 `php artisan db:seed --class=ModuleUserSeed`