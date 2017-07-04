<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\$NAME$\User\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'          => $faker->name,
        'email'         => $faker->unique()->safeEmail,
        'password'      => $password ?: $password = bcrypt('secret'),
        'gender'        => $faker->randomElement([\$NAME$\User\Models\User::GENDER_MALE, \$NAME$\User\Models\User::GENDER_FEMALE]),
        'mobile'        => $faker->phoneNumber,
        'is_active'     => $faker->boolean(),
        'last_login_at' => null,
        'login_times'   => 0
    ];
});
