<?php

namespace App\Modules\Hospital\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Hospital\Models\Appointment;
use App\Modules\Hospital\Models\Patient;
use App\Modules\Hospital\Models\Visit;
use App\Services\AuditLogService;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogService)
    {
    }

    public function index()
    {
        $visits = Visit::query()->with(['patient', 'appointment'])->latest('visited_at')->paginate(20);

        return view('modules.hospital.visits.index', compact('visits'));
    }

    public function create()
    {
        $patients = Patient::query()->orderBy('first_name')->get();
        $appointments = Appointment::query()->latest('appointment_at')->limit(100)->get();

        return view('modules.hospital.visits.create', compact('patients', 'appointments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => ['required', 'exists:hospital_patients,id'],
            'appointment_id' => ['nullable', 'exists:hospital_appointments,id'],
            'visited_at' => ['required', 'date'],
            'diagnosis' => ['nullable', 'string'],
            'treatment' => ['nullable', 'string'],
        ]);

        $visit = Visit::query()->create($data);
        $this->auditLogService->log('hospital.visit.created', Visit::class, $visit->id);

        return redirect()->route('hospital.visits.index')->with('success', 'Visit saved.');
    }

    public function show(Visit $visit)
    {
        $visit->load(['patient', 'appointment']);

        return view('modules.hospital.visits.show', compact('visit'));
    }
}
