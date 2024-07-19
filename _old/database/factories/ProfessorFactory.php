<?php

use App\Model;
use App\Models\Usuarios\Professor;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

/** @var Factory $factory */
$factory->define(Professor::class, function (Faker $faker) {
    return [
        'matricula' => Str::random()
    ];
});
