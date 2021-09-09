<?php
namespace App\Traits;
use Illuminate\Support\Str;

trait UserTrait {

    public function cachedRoles(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->roles()->get();
    }

    public function hasPermission($permission): bool
    {
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                if($permission->name == $permission) return true;
            }
        }

        return false;
    }


    public function hasRole($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = self::hasRole($roleName);

                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            foreach ($this->cachedRoles() as $role) {
                if ($role->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }



    public function can($permission, $requireAll = false)
    {
        if (is_array($permission)) {
            foreach ($permission as $permName) {
                $hasPerm = $this->can($permName);

                if ($hasPerm && !$requireAll) {
                    return true;
                } elseif (!$hasPerm && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            foreach ($this->cachedRoles() as $role) {
                foreach ($role->cachedPermissions() as $perm) {
                    if (Str::is( $permission, $perm->name) ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }


}
