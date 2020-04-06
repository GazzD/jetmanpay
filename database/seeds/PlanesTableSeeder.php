<?php

use Illuminate\Database\Seeder;
use App\Plane;

class PlanesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plane::create([
            'id' => 1,
            'tail_number' => 'N197UA',
            'client_id' => 1
        ]);
        
        Plane::create([
            'id' => 2,
            'tail_number' => 'GEN00017',
            'client_id' => 1
        ]);
        
        Plane::create([
            'id' => 3,
            'tail_number' => 'GEN10495',
            'client_id' => 2
        ]);
        
        Plane::create([
            'id' => 4,
            'tail_number' => 'AF00001',
            'client_id' => 2
        ]);
        
        Plane::create([
            'id' => 5,
            'tail_number' => 'AF00002',
            'client_id' => 2
        ]);
    }
}
