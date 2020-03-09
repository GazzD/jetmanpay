<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'dosa_number' => 'JMP-'.$faker->numerify('####'),
        'dosa_date' => $faker->date('Y-m-d H:i:s'),
        'total_amount' => $faker->numberBetween(100,2000),
        'tail_number' => $faker->numerify('####').'ABC',
        'status' => 'PENDING',
        'client_id' => 1,
        'user_id' => 1,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
    ];
});
