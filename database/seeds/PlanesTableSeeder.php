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
            'tail_number' => 'PLANE 1',
            'client_id' => 1
        ]);

        Plane::create([
            'id' => 2,
            'tail_number' => 'PLANE 2',
            'client_id' => 1
        ]);

        Plane::create([
            'id' => 3,
            'tail_number' => 'AVION 1',
            'client_id' => 2
        ]);
        Plane::create([
            'id' => 4,
            'tail_number' => 'AVION 2',
            'client_id' => 2
        ]);

        Plane::create([
            'id' => 5,
            'tail_number' => 'AVION 3',
            'client_id' => 2
        ]);
    }
}
