<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
	return [
        'name' => $faker->company,
        'description' => $faker->paragraph,
        'is_hunter' => false,
        'email' => $faker->email,
        'password' => $faker->text,
    ];
});
