<?php

use App\Model;
use App\Models\Usuarios\Aluno;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

/** @var Factory $factory */
$factory->define(Aluno::class, function (Faker $faker) {
    return [
        'prontuario' => Str::random()
    ];
});
