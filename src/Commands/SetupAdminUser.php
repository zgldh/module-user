<?php namespace zgldh\ModuleUser\Commands;

use Illuminate\Console\Command;

class SetupAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zgldh:user:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the admin user, super-admin role.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Resetting admin user...');
        $ns = $this->moduleRootNamespace();
        $user = app($ns . '\User\Models\User');
        $user = $user->firstOrNew(['name' => 'admin']);
        $user->email = 'admin@email.com';
        $user->password = bcrypt('123456');
        $user->save();
        $this->line('name: admin');
        $this->line('email: admin@email.com');
        $this->line('password: 123456');

        $role = app($ns . '\User\Models\Role');
        $role = $role->firstOrNew(['name' => 'super-admin']);
        $role->label = '超级管理员';
        $role->save();
        if (!$user->hasRole($role)) {
            $user->assignRole($role);
        }
        $this->line('role: ' . 'super-admin');

        $permission = app($ns . '\User\Models\Permission');
        $permission = $permission->firstOrNew(['name' => 'can-manage-user']);
        $permission->label = $permission->label ?: '管理用户';
        $permission->save();
        if (!$role->hasPermissionTo($permission)) {
            $role->givePermissionTo($permission);
        }
        $this->line('permission: ' . 'can-manage-user');
        $this->line('Complete!');
    }

    protected function moduleRootNamespace()
    {
        return config('zgldh-scaffold.modules', 'Modules');
    }
}
