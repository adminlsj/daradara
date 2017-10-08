<?php

use Faker\Generator as Faker;

$factory->define(App\OrderImg::class, function (Faker $faker) {
    return [
    	'order_id' => 1,
        'filename' => 'phpfhAWAe',
        'mime' => 'image/jpeg',
        'original_filename' => $faker->name.'.jpg',
    ];
});
