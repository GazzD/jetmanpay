<?php

use Illuminate\Database\Seeder;
use App\System;

class SystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system = new System();
        $system->balance_usd = 500000;
        $system->balance_bs = 1000000;
        $system->balance_eu = 400000;
        $system->status = 'ACTIVE';
        $system->save();
    }
}
