<?php

use Illuminate\Database\Seeder;

class ModuleUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $users = factory(\$NAME$\User\Models\User::class, 100)->create();
    }
}
