<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->userName,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\UserProfile::class, function (Faker\Generator $faker) {
    return [
        'fullname' => $faker->name,
        'country' => $faker->country,
        'city' => $faker->city,
        'birthdate' => $faker->dateTimeThisCentury($max = '-15 years') ,
        'description' => $faker->text($maxNbChars = 200),
        'image' => $faker->md5,
        'social_facebook' => $faker->userName,
        'social_twitter' => $faker->userName,
        'social_youtube' => $faker->userName,
        'social_instagram' => $faker->userName,
        'social_snapchat' => $faker->userName,
    ];
});
