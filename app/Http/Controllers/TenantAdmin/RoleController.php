<?php

namespace App\Http\Controllers\TenantAdmin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = $request->user()->tenant_id;

        $roles = Role::query()
            ->where(function ($query) use ($tenantId) {
                $query->whereNull('tenant_id')->orWhere('tenant_id', $tenantId);
            })
            ->with('permissions')
            ->orderBy('name')
            ->get();

        $permissions = Permission::query()->orderBy('module')->orderBy('slug')->get();

        return view('tenant-admin.roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:100'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role = Role::query()->create([
            'tenant_id' => $request->user()->tenant_id,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'scope' => 'tenant',
        ]);

        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('tenant-admin.roles.index')->with('success', 'Role created.');
    }

    public function update(Request $request, Role $role)
    {
        abort_unless($role->tenant_id === null || $role->tenant_id === $request->user()->tenant_id, 403);

        $data = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('tenant-admin.roles.index')->with('success', 'Role permissions updated.');
    }
}
