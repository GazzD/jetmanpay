<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'id'      => 1,
            'code'      => '00005',
            'name'      => 'Vene Airlines',
            ]);
            Client::create([
            'id'      => 2,
            'code'      => '00006',
            'name'      => 'Test Airlines',
        ]);
    }
}
