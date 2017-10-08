<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
	$users = App\User::all()->count();
	$category = array_keys(App\Order::$category);
	$country = array_keys(App\Order::$country);
    return [
        'user_id' => random_int(1, $users),
        'name' => $faker->sentence,
        'price' => random_int(1, 1000),
        'description' => $faker->paragraph,
        'category' => $category[random_int(0, count($category)-1)],
        'country' => $country[random_int(0, count($category)-1)],
        'link' => $faker->sentence,
        'end_date' => $faker->dateTimeBetween($startDate = "now", $endDate = "60 days")->format('Y-m-d'),
        'is_payed' => true,
    ];
});
