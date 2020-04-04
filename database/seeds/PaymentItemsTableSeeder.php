<?php

use App\PaymentItem;
use Illuminate\Database\Seeder;

class PaymentItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentItem::create([
            'concept'           => 'Concept 1',
            'amount'            => 10,
            'fee'    => 10,
            'payment_id'        => 1
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 2',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 1
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 3',
            'amount'            => 62620,
            'fee'    => 20,
            'payment_id'        => 2
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 4',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 3
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 5',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 3
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 6',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 3
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 7',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 3
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 8',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 4
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 9',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 4
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 10',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 4
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 11',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 1
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 12',
            'amount'            => 20,
            // 'fee'    => 20,
            'payment_id'        => 2
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 13',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 3
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 14',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 1
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 15',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 2
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 16',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 1
        ]);
        PaymentItem::create([
            'concept'           => 'Concept 17',
            'amount'            => 20,
            'fee'    => 20,
            'payment_id'        => 2
        ]);
    }
}
