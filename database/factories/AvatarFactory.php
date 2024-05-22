<?php

use Faker\Generator as Faker;

$factory->define(App\Avatar::class, function (Faker $faker) {
    return [
        'mime' => 'image',
        'filename' => 'default_freerider_profile_pic',
        'original_filename' => 'default',
    ];
});
