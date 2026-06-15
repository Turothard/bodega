<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Posicione;
use App\Estante;
use App\Articulo;

$factory->define(Posicione::class, function (Faker $faker) {
    $est=Estante::all()->random(1)[0];
    return [
        'estante_id' => $est['id'],
        'sectorpos' =>$faker->numberBetween($min = 1, $max = $est['sectoresest']),
        'nivelpos' =>$faker->numberBetween($min = 1, $max =$est['nivelesest']),
        'codigoart'=>Articulo::all()->random(1)[0]['codigoart'],
        'cantidadpos'=> $faker->numberBetween($min = 3, $max =10)
    ];
});
