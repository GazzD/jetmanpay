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
        User::create([
            'name' => 'Tesorero 1',
            'email' => 'treasurer1@treasurer.com',
            'password' => Hash::make('test'),
            'client_id' => 1
        ]);
        User::create([
            'name' => 'Tesorero 2',
            'email' => 'treasurer2@treasurer.com',
            'password' => Hash::make('test'),
            'client_id' => 1
        ]);
        User::create([
            'name' => 'Fernando Aloso',
            'email' => 'reviewer@reviewer.com',
            'password' => Hash::make('test')
        ]);
        User::create([
            'name' => 'Joan Fernández',
            'email' => 'staff@staff.com',
            'password' => Hash::make('test')
        ]);
    }
}
