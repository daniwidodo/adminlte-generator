<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CatUser;
use Faker\Generator as Faker;

$factory->define(CatUser::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'email' => $faker->word,
        'password' => $faker->word,
        'avatar' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
