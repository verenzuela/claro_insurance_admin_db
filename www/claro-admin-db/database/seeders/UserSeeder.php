<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_root = Role::where('name', 'admin')->first();

        $userAdmin = new User();
        $userAdmin->setAttribute('name', 'Admin');
        $userAdmin->setAttribute('email', 'admin@admin.com');
        $userAdmin->setAttribute('password', Hash::make('12345678'));
        $userAdmin->save();

        $userAdmin->roles()->attach($role_root);

    }
}
