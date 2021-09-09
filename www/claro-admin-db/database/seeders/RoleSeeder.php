<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Administrator role']);
        Role::create(['name' => 'guest', 'display_name' => 'Guest', 'description' => 'Guest role']);
        Role::create(['name' => 'authenticated', 'display_name' => 'Authenticated', 'description' => 'Authenticated role']);
    }
}
