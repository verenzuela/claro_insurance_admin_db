<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminId = Role::where('name', 'admin')->value('id');

        $permissions = Permission::get();
        foreach ($permissions as $permission) {
            PermissionRole::create(['permission_id' => $permission->id, 'role_id' => $adminId]);
        }
    }
}
