<?php

namespace App\Modules\Property\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Property\Models\Lease;
use App\Modules\Property\Models\RentalTenant;
use App\Modules\Property\Models\Unit;
use App\Modules\Property\Requests\StoreLeaseRequest;
use App\Services\AuditLogService;

class LeaseController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $leases = Lease::query()->with(['unit.property', 'rentalTenant'])->latest()->paginate(20);

        return view('modules.property.leases.index', compact('leases'));
    }

    public function create()
    {
        $units = Unit::query()->with('property')->orderBy('unit_no')->get();

        return view('modules.property.leases.create', compact('units'));
    }

    public function store(StoreLeaseRequest $request)
    {
        $rentalTenant = RentalTenant::query()->create([
            'name' => $request->input('tenant_name'),
            'phone' => $request->input('tenant_phone'),
            'email' => $request->input('tenant_email'),
        ]);

        $lease = Lease::query()->create([
            'unit_id' => $request->integer('unit_id'),
            'rental_tenant_id' => $rentalTenant->id,
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'rent_amount' => $request->input('rent_amount'),
            'deposit_amount' => $request->input('deposit_amount', 0),
            'status' => 'active',
        ]);

        Unit::query()->find($lease->unit_id)?->update(['status' => 'occupied']);

        $this->auditLogService->log('property.lease.created', Lease::class, $lease->id);

        return redirect()->route('property.leases.index')->with('success', 'Lease created.');
    }

    public function show(Lease $lease)
    {
        $lease->load(['unit.property', 'rentalTenant', 'rentInvoices']);

        return view('modules.property.leases.show', compact('lease'));
    }
}
