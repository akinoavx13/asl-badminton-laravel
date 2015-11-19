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

use Carbon\Carbon;

$factory->define(App\User::class, function (Faker\Generator $faker)
{
    return [
        'name'                   => $faker->firstName,
        'forname'                => $faker->lastName,
        'email'                  => $faker->email,
        'password'               => bcrypt('mmmmmm'),
        'remember_token'         => str_random(10),
        'birthday'               => Carbon::create(1996, 9, 20)->format('d/m/Y'),
        'tshirt_size'            => 'M',
        'gender'                 => 'man',
        'avatar'                 => false,
        'address'                => $faker->address,
        'phone'                  => $faker->phoneNumber,
        'state'                  => 'active',
        'lectra_relationship'    => 'conjoint',
        'newsletter'             => true,
        'role'                   => 'user',
        'active'                 => true,
        'ending_holiday'         => Carbon::now()->format('d/m/Y'),
        'ending_injury'          => Carbon::now()->format('d/m/Y'),
        'first_connect'          => true,
        'token_first_connection' => str_random(60),
    ];
});
