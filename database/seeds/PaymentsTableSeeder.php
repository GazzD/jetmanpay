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
            'invoice_number'=> time(),
            'dosa_date'     => '2020-01-01',
            'number'        => 'ISP-'.$this->generateRandomString(),
            'total_amount'  => 100,
            'reference'     => 'REFERENCIA 1',
            'description'   => 'DESCRIPCIÓN 1',
            'status'        => 'PENDING',
            'currency'      => 'USD',
            'client_id'     => 1,
            'plane_id'      => 1,
            'user_id'       => 1
        ]);
        Payment::create([
            'dosa_number'   => '0002',
            'invoice_number'=> time(),
            'dosa_date'     => '2020-01-01',
            'number'        => 'ISP-'.$this->generateRandomString(),
            'total_amount'  => 5000,
            'reference'     => 'REFERENCIA 2',
            'description'   => 'DESCRIPCIÓN 2',
            'status'        => 'PENDING',
            'currency'      => 'VEF',
            'client_id'     => 1,
            'plane_id'      => 1,
            'user_id'       => 1
        ]);
        Payment::create([
            'dosa_number'   => '0003',
            'invoice_number'=> time(),
            'dosa_date'     => '2020-01-01',
            'number'        => 'ISP-'.$this->generateRandomString(),
            'total_amount'  => 1161,
            'reference'     => 'REFERENCIA 3',
            'description'   => 'DESCRIPCIÓN 3',
            'status'        => 'PENDING',
            'currency'      => 'USD',
            'client_id'     => 1,
            'plane_id'      => 2,
            'user_id'       => 1
        ]);
        Payment::create([
            'dosa_number'   => '0004',
            'invoice_number'=> time(),
            'dosa_date'     => '2020-01-01',
            'number'        => 'ISP-'.$this->generateRandomString(),
            'total_amount'  => 101220,
            'reference'     => 'REFERENCIA 4',
            'description'   => 'DESCRIPCIÓN 4',
            'status'        => 'PENDING',
            'currency'      => 'USD',
            'client_id'     => 2,
            'plane_id'      => 4,
            'user_id'       => 2
        ]);
    }
    
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
