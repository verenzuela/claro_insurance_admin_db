<?php

namespace Database\Seeders;

use App\Models\EndPoint;
use App\Models\Fruit;
use Illuminate\Database\Seeder;

class FruitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fruit::create(['name' => 'Apple']);
        Fruit::create(['name' => 'Peach']);
        Fruit::create(['name' => 'pineapple']);
    }
}
