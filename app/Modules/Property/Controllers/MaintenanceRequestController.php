<?php

namespace App\Modules\Property\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Property\Models\MaintenanceRequest;
use App\Modules\Property\Models\Unit;
use App\Modules\Property\Requests\StoreMaintenanceRequest;
use App\Services\AuditLogService;

class MaintenanceRequestController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $requests = MaintenanceRequest::query()->with('unit.property')->latest()->paginate(20);

        return view('modules.property.maintenance.index', compact('requests'));
    }

    public function create()
    {
        $units = Unit::query()->with('property')->orderBy('unit_no')->get();

        return view('modules.property.maintenance.create', compact('units'));
    }

    public function store(StoreMaintenanceRequest $request)
    {
        $maintenanceRequest = MaintenanceRequest::query()->create($request->validated());
        $this->auditLogService->log('property.maintenance.created', MaintenanceRequest::class, $maintenanceRequest->id);

        return redirect()->route('property.maintenance.index')->with('success', 'Maintenance request opened.');
    }

    public function show(MaintenanceRequest $maintenance)
    {
        $maintenance->load('unit.property');

        return view('modules.property.maintenance.show', compact('maintenance'));
    }

    public function update(StoreMaintenanceRequest $request, MaintenanceRequest $maintenance)
    {
        $maintenance->update($request->validated());
        $this->auditLogService->log('property.maintenance.updated', MaintenanceRequest::class, $maintenance->id);

        return redirect()->route('property.maintenance.show', $maintenance)->with('success', 'Maintenance request updated.');
    }
}
