<?php

namespace App\Http\Controllers\TenantAdmin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = $request->user()->tenant_id;

        $users = User::query()
            ->where('tenant_id', $tenantId)
            ->with('roles')
            ->latest()
            ->paginate(20);

        $roles = Role::query()->where(function ($query) use ($tenantId) {
            $query->whereNull('tenant_id')->orWhere('tenant_id', $tenantId);
        })->orderBy('name')->get();

        return view('tenant-admin.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $tenantId = $request->user()->tenant_id;

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $user = User::query()->create([
            'tenant_id' => $tenantId,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
            'is_super_admin' => false,
            'is_active' => true,
        ]);

        $user->roles()->sync($data['roles'] ?? []);

        return redirect()->route('tenant-admin.users.index')->with('success', 'User created.');
    }

    public function update(Request $request, User $user)
    {
        abort_unless($request->user()->tenant_id === $user->tenant_id, 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'is_active' => ['nullable', 'boolean'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $user->roles()->sync($data['roles'] ?? []);

        return redirect()->route('tenant-admin.users.index')->with('success', 'User updated.');
    }
}
