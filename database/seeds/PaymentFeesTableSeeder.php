<?php

use App\PaymentFee;
use Illuminate\Database\Seeder;

class PaymentFeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentFee::create([
            'old_code'          => '0001',
            'concept'           => 'Concept 1',
            'amount'            => 10,
            'conversion_fee'    => 10,
            'payment_id'        => 1
        ]);
        PaymentFee::create([
            'old_code'          => '0002',
            'concept'           => 'Concept 2',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 1
        ]);
    }
}