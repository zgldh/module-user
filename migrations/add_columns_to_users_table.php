<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender', 8)->nullable(); // Male, Female
            $table->string('mobile')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamp('last_login_at')->nullable();
            $table->integer('login_times')->default(0);
            $table->integer('avatar_id')->nullable();
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->string('label');
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('label');
        });

        $this->createBasicAdmin();
    }

    private function createBasicAdmin()
    {
        $user = \$NAME$\User\Models\User::firstOrNew(['name' => 'admin']);
        $user->email = 'admin@email.com';
        $user->password = bcrypt('123456');
        $user->save();

        $role = \$NAME$\User\Models\Role::firstOrNew(['name' => 'admin']);
        $role->label = $role->label ?: '管理员';
        $role->save();
        if (!$user->hasRole($role)) {
            $user->assignRole($role);
        }

        $permission = \$NAME$\User\Models\Permission::firstOrNew(['name' => 'can-manage-user']);
        $permission->label = $permission->label ?: '管理用户';
        $permission->save();
        if (!$role->hasPermissionTo($permission)) {
            $role->givePermissionTo($permission);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('mobile');
            $table->dropColumn('is_active');
            $table->dropColumn('last_login_at');
            $table->dropColumn('login_times');
            $table->dropColumn('avatar_id');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('label');
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('label');
        });
    }
}
