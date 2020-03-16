<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PaymentDocument;
use Faker\Generator as Faker;
use App\Payment;

$factory->define(PaymentDocument::class, function (Faker $faker) {
    return [
        'url' => 'JMP-'.$faker->url,
        'name' => $faker->name,
        'payment_id' => Payment::all()->random()->id,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
    ];
});
