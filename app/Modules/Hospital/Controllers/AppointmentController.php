<?php

namespace App\Modules\Hospital\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Hospital\Models\Appointment;
use App\Modules\Hospital\Models\Doctor;
use App\Modules\Hospital\Models\Patient;
use App\Modules\Hospital\Requests\StoreAppointmentRequest;
use App\Services\AuditLogService;

class AppointmentController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $appointments = Appointment::query()->with(['patient', 'doctor'])->latest('appointment_at')->paginate(20);

        return view('modules.hospital.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::query()->orderBy('first_name')->get();
        $doctors = Doctor::query()->orderBy('name')->get();

        return view('modules.hospital.appointments.create', compact('patients', 'doctors'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        $appointment = Appointment::query()->create($request->validated());
        $this->auditLogService->log('hospital.appointment.created', Appointment::class, $appointment->id);

        return redirect()->route('hospital.appointments.index')->with('success', 'Appointment scheduled.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor']);

        return view('modules.hospital.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::query()->orderBy('first_name')->get();
        $doctors = Doctor::query()->orderBy('name')->get();

        return view('modules.hospital.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(StoreAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());
        $this->auditLogService->log('hospital.appointment.updated', Appointment::class, $appointment->id);

        return redirect()->route('hospital.appointments.show', $appointment)->with('success', 'Appointment updated.');
    }
}
