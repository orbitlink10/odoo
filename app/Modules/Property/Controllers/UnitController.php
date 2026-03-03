<?php

namespace App\Modules\Property\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Property\Models\Property;
use App\Modules\Property\Models\Unit;
use App\Modules\Property\Requests\StoreUnitRequest;
use App\Services\AuditLogService;

class UnitController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $units = Unit::query()->with('property')->latest()->paginate(20);

        return view('modules.property.units.index', compact('units'));
    }

    public function create()
    {
        $properties = Property::query()->orderBy('name')->get();

        return view('modules.property.units.create', compact('properties'));
    }

    public function store(StoreUnitRequest $request)
    {
        $unit = Unit::query()->create($request->validated());
        $this->auditLogService->log('property.unit.created', Unit::class, $unit->id);

        return redirect()->route('property.units.index')->with('success', 'Unit created.');
    }

    public function show(Unit $unit)
    {
        $unit->load(['property', 'leases']);

        return view('modules.property.units.show', compact('unit'));
    }

    public function edit(Unit $unit)
    {
        $properties = Property::query()->orderBy('name')->get();

        return view('modules.property.units.edit', compact('unit', 'properties'));
    }

    public function update(StoreUnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        $this->auditLogService->log('property.unit.updated', Unit::class, $unit->id);

        return redirect()->route('property.units.show', $unit)->with('success', 'Unit updated.');
    }
}
