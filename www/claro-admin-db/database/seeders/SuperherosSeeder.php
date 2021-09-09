<?php

namespace Database\Seeders;

use App\Models\Superhero;
use Illuminate\Database\Seeder;

class SuperherosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Superhero::create(['name' => 'Iroman', 'gender' => 'male']);
        Superhero::create(['name' => 'Black Widow', 'gender' => 'female']);
        Superhero::create(['name' => 'Thor', 'gender' => 'male']);
    }
}
