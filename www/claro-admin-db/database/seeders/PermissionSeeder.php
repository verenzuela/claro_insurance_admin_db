<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            #roles
            ['name' => 'role.list','display_name' => 'Role - Listing Display','description' => 'See only Listing Of Role'],
            ['name' => 'role.create','display_name' => 'Role - Create','description' => 'Create New Role'],
            ['name' => 'role.edit','display_name' => 'Role - Edit','description' => 'Edit Role'],
            ['name' => 'role.delete','display_name' => 'Role - Delete','description' => 'Delete Role'],

            #user
            ['name' => 'user.list','display_name' => 'User - Listing Display','description' => 'See only Listing Of Users'],
            ['name' => 'user.create','display_name' => 'User - Create','description' => 'Create New User'],
            ['name' => 'user.edit','display_name' => 'User - Edit','description' => 'Edit User'],
            ['name' => 'user.delete','display_name' => 'User - Delete','description' => 'Delete User'],

            #permission
            ['name' => 'permission.list','display_name' => 'Permission - Listing Display','description' => 'Permission listing display option'],
            ['name' => 'permission.create','display_name' => 'Permission - Create','description' => 'Permission create permission'],
            ['name' => 'permission.edit','display_name' => 'Permission - Edit','description' => 'Edit permission'],
            ['name' => 'permission.delete','display_name' => 'Permission - Delete','description' => 'Permission delete option'],

            #superheros
            ['name' => 'superhero.list','display_name' => 'Permission - Listing Display','description' => 'Permission listing display option'],
            ['name' => 'superhero.create','display_name' => 'Permission - Create','description' => 'Permission create superhero'],
            ['name' => 'superhero.edit','display_name' => 'Permission - Edit','description' => 'Edit permission'],
            ['name' => 'superhero.delete','display_name' => 'Permission - Delete','description' => 'Permission delete option'],

            #fruits
            ['name' => 'fruit.list','display_name' => 'Permission - Listing Display','description' => 'Permission listing display option'],
            ['name' => 'fruit.create','display_name' => 'Permission - Create','description' => 'Permission create fruit'],
            ['name' => 'fruit.edit','display_name' => 'Permission - Edit','description' => 'Edit permission'],
            ['name' => 'fruit.delete','display_name' => 'Permission - Delete','description' => 'Permission delete option'],

            #endpoint
            ['name' => 'endpoint.list','display_name' => 'Permission - Listing Display','description' => 'Permission listing display option'],
            ['name' => 'endpoint.create','display_name' => 'Permission - Create','description' => 'Permission create endpoint'],
            ['name' => 'endpoint.edit','display_name' => 'Permission - Edit','description' => 'Edit permission'],
            ['name' => 'endpoint.delete','display_name' => 'Permission - Delete','description' => 'Permission delete option']
        ];

        foreach ($permission as $value) {
            Permission::create($value);
        }
    }
}
