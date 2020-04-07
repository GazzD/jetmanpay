<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = Role::create(['name' => 'MANAGER']);
        $operator = Role::create(['name' => 'OPERATOR']);
        $client = Role::create(['name' => 'CLIENT']);
        Role::create(['name' => 'REVIEWER']);
        Role::create(['name' => 'STAFF']);
        
        $user = User::find(1);
        $user->assignRole($manager);
        
        $user = User::find(2);
        $user->assignRole($operator);
        
        $user = User::find(3);
        $user->assignRole($client);
    }
}
