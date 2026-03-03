<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::query()->withCount('users')->latest()->paginate(20);

        return view('admin.tenants.index', compact('tenants'));
    }

    public function show(Tenant $tenant)
    {
        $tenant->load(['users.roles', 'subscriptions.modules']);

        return view('admin.tenants.show', compact('tenant'));
    }

    public function updateStatus(Request $request, Tenant $tenant)
    {
        $tenant->update(['is_active' => $request->boolean('is_active')]);

        return redirect()->route('admin.tenants.show', $tenant)->with('success', 'Tenant status updated.');
    }
}
