<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(PermissionRoleSeeder::class);

        $this->call(UserSeeder::class);
        $this->call(EndpoitsSeeder::class);
        $this->call(FruitsSeeder::class);
        $this->call(SuperherosSeeder::class);

    }
}
