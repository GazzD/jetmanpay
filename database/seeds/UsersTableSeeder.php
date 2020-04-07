<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Víctor Cardozo',
            'email' => 'manager@manager.com',
            'password' => Hash::make('test'),
        ]);
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'operator@operator.com',
            'password' => Hash::make('test'),
        ]);
        User::create([
            'name' => 'Alfonso Martinez',
            'email' => 'client@client.com',
            'password' => Hash::make('test'),
            'client_id' => 1
        ]);
    }
}
