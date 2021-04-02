<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Modules\ElasticSearch\Models\Book as ModelsBook;

$factory->define(ModelsBook::class, function (Faker $faker) {
    return [
        'title' => Str::title($faker->words($nb = 5, $asText = true)),
        'limit_date' => rand(0, 30),
        'status' => rand(0, 1),
        'price' => rand(10, 100)
    ];
});
