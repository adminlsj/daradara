<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
	$users = App\User::all()->count();
	$orders = App\Order::all()->count();
    return [
        'user_id' => random_int(1, $users),
        'order_id' => random_int(1, $orders),
        'text' => $faker->sentence,
    ];
});
