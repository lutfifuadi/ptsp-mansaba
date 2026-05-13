<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleManagementController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        return view('content.pages.admin.role.management.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->roleService->getAllPermissions();
        return view('content.pages.admin.role.management.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
        ]);

        $this->roleService->createRole($data);

        return redirect()->route('admin.role-management.index')->with('success', 'Role berhasil dibuat.');
    }

    public function edit(Role $role)
    {
        $permissions = $this->roleService->getAllPermissions();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('content.pages.admin.role.management.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $this->roleService->updateRole($role, $data);

        return redirect()->route('admin.role-management.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        try {
            $this->roleService->deleteRole($role);
            return redirect()->route('admin.role-management.index')->with('success', 'Role berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.role-management.index')->with('error', $e->getMessage());
        }
    }
}
