<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleService
{
    /**
     * Get all roles with their permissions.
     */
    public function getAllRoles()
    {
        return Role::with('permissions')->get();
    }

    /**
     * Create a new role.
     */
    public function createRole(array $data)
    {
        $role = Role::create(['name' => $data['name']]);
        
        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }
        
        return $role;
    }

    /**
     * Update an existing role.
     */
    public function updateRole(Role $role, array $data)
    {
        $role->update(['name' => $data['name']]);
        
        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }
        
        return $role;
    }

    /**
     * Delete a role.
     */
    public function deleteRole(Role $role)
    {
        if (in_array($role->name, ['admin', 'operator'])) {
            throw new \Exception("Role '{$role->name}' tidak dapat dihapus.");
        }

        $usersCount = User::role($role->name)->count();
        if ($usersCount > 0) {
            throw new \Exception("Role '{$role->name}' masih digunakan oleh {$usersCount} pengguna. Pindahkan pengguna ke role lain terlebih dahulu.");
        }

        return $role->delete();
    }

    /**
     * Get all permissions grouped by category (optional).
     */
    public function getAllPermissions()
    {
        return Permission::all();
    }
}
