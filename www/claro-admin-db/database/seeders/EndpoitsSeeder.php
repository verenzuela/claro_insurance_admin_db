<?php

namespace Database\Seeders;

use App\Models\EndPoint;
use Illuminate\Database\Seeder;

class EndpoitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EndPoint::create(['name' => 'fruits']);
        EndPoint::create(['name' => 'superheros']);
    }
}
