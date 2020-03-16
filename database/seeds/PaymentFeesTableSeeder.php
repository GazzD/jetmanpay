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
        PaymentFee::create([
            'old_code'          => '0003',
            'concept'           => 'Concept 3',
            'amount'            => 62620,
            'conversion_fee'    => 20,
            'payment_id'        => 2
        ]);
        PaymentFee::create([
            'old_code'          => '0004',
            'concept'           => 'Concept 4',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 3
        ]);
        PaymentFee::create([
            'old_code'          => '0005',
            'concept'           => 'Concept 5',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 3
        ]);
        PaymentFee::create([
            'old_code'          => '0006',
            'concept'           => 'Concept 6',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 3
        ]);
        PaymentFee::create([
            'old_code'          => '0007',
            'concept'           => 'Concept 7',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 3
        ]);
        PaymentFee::create([
            'old_code'          => '0008',
            'concept'           => 'Concept 8',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 4
        ]);
        PaymentFee::create([
            'old_code'          => '0009',
            'concept'           => 'Concept 9',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 4
        ]);
        PaymentFee::create([
            'old_code'          => '0010',
            'concept'           => 'Concept 10',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 4
        ]);
        PaymentFee::create([
            'old_code'          => '0011',
            'concept'           => 'Concept 11',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 1
        ]);
        PaymentFee::create([
            'old_code'          => '0012',
            'concept'           => 'Concept 12',
            'amount'            => 20,
            // 'conversion_fee'    => 20,
            'payment_id'        => 2
        ]);
        PaymentFee::create([
            'old_code'          => '0013',
            'concept'           => 'Concept 13',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 3
        ]);
        PaymentFee::create([
            'old_code'          => '0014',
            'concept'           => 'Concept 14',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 1
        ]);
        PaymentFee::create([
            'old_code'          => '0015',
            'concept'           => 'Concept 15',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 2
        ]);
        PaymentFee::create([
            'old_code'          => '0016',
            'concept'           => 'Concept 16',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 1
        ]);
        PaymentFee::create([
            'old_code'          => '0017',
            'concept'           => 'Concept 17',
            'amount'            => 20,
            'conversion_fee'    => 20,
            'payment_id'        => 2
        ]);
    }
}
