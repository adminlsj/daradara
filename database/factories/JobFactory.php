<?php

use Faker\Generator as Faker;

$factory->define(App\Job::class, function (Faker $faker) {
	$companies = App\Company::all()->count();
    $country = array_keys(App\Job::$country);
	$category = array_keys(App\Job::$category);
    $level = array_keys(App\Job::$level);
    $type = array_keys(App\Job::$type);
    $education = array_keys(App\Job::$education);
    
    return [
        'company_id' => random_int(1, $companies),
        'title' => $faker->jobTitle,
        'location' => $country[random_int(0, count($country)-1)],
        'category' => $category[random_int(0, count($category)-1)],
        'salary' => random_int(1, 100000),
        'level' => $level[random_int(0, count($level)-1)],
        'type' => $type[random_int(0, count($type)-1)],
        'education' => $education[random_int(0, count($education)-1)],
        'responsibility' => $faker->paragraph($nbSentences = 10, $variableNbSentences = true),
        'requirement' => $faker->paragraph($nbSentences = 10, $variableNbSentences = true),
        'experience' => random_int(0, 20),
    ];
});
