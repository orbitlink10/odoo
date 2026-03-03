<?php

namespace App\Modules\Hospital\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Hospital\Models\Patient;
use App\Modules\Hospital\Requests\StorePatientRequest;
use App\Services\AuditLogService;

class PatientController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $patients = Patient::query()->latest()->paginate(20);

        return view('modules.hospital.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('modules.hospital.patients.create');
    }

    public function store(StorePatientRequest $request)
    {
        $patient = Patient::query()->create($request->validated());
        $this->auditLogService->log('hospital.patient.created', Patient::class, $patient->id);

        return redirect()->route('hospital.patients.index')->with('success', 'Patient created.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['appointments', 'bills']);

        return view('modules.hospital.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('modules.hospital.patients.edit', compact('patient'));
    }

    public function update(StorePatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());
        $this->auditLogService->log('hospital.patient.updated', Patient::class, $patient->id);

        return redirect()->route('hospital.patients.show', $patient)->with('success', 'Patient updated.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        $this->auditLogService->log('hospital.patient.deleted', Patient::class, $patient->id);

        return redirect()->route('hospital.patients.index')->with('success', 'Patient archived.');
    }
}
