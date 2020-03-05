<?php

use App\Payment;
use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create([
            'dosa_number'   => '0001',
            'dosa_date'     => '2020-01-01',
            'total_amount'  => 100,
            'tail_number'   => '001ABC',
            'status'        => 'PENDING',
            'client_id'     => 1,
            'user_id'       => 1
        ]);
    }
}