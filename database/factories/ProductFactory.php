<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name, // sentence
        'description' => $faker->sentence, // paragraph
        'price' => $faker->randomNumber(2)
    ];
});
