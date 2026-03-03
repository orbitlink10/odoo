<?php

namespace App\Modules\Property\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Property\Models\Property;
use App\Modules\Property\Requests\StorePropertyRequest;
use App\Services\AuditLogService;

class PropertyController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $properties = Property::query()->latest()->paginate(20);

        return view('modules.property.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('modules.property.properties.create');
    }

    public function store(StorePropertyRequest $request)
    {
        $property = Property::query()->create($request->validated());
        $this->auditLogService->log('property.created', Property::class, $property->id);

        return redirect()->route('property.properties.index')->with('success', 'Property created.');
    }

    public function show(Property $property)
    {
        $property->load('units');

        return view('modules.property.properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        return view('modules.property.properties.edit', compact('property'));
    }

    public function update(StorePropertyRequest $request, Property $property)
    {
        $property->update($request->validated());
        $this->auditLogService->log('property.updated', Property::class, $property->id);

        return redirect()->route('property.properties.show', $property)->with('success', 'Property updated.');
    }

    public function destroy(Property $property)
    {
        $property->delete();
        $this->auditLogService->log('property.deleted', Property::class, $property->id);

        return redirect()->route('property.properties.index')->with('success', 'Property archived.');
    }
}
