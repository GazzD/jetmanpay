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
        $reviewer = Role::create(['name' => 'REVIEWER']);
        $staff = Role::create(['name' => 'STAFF']);
        $treasurer1 = Role::create(['name' => 'TREASURER1']);
        $treasurer2 = Role::create(['name' => 'TREASURER2']);
        
        $user = User::find(1);
        $user->assignRole($manager);
        
        $user = User::find(2);
        $user->assignRole($operator);
        
        $user = User::find(3);
        $user->assignRole($client);
        
        $user = User::find(4);
        $user->assignRole($treasurer1);
        
        $user = User::find(5);
        $user->assignRole($treasurer2);
        
        $user = User::find(6);
        $user->assignRole($reviewer);
        
        $user = User::find(7);
        $user->assignRole($staff);
    }
}
