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
            'name' => 'Víctor',
            'email' => 'manager@manager.com',
            'password' => Hash::make('test'),
            'role_id' => 1,
        ]);
        User::create([
            'name' => 'Anibal',
            'email' => 'operator@operator.com',
            'password' => Hash::make('test'),
            'role_id' => 2,
        ]);
    }
}
